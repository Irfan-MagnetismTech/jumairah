<?php

namespace App\Http\Controllers\Boq\Departments\Civil\ConversionSheet;

use App\Boq\Departments\Civil\ConversionSheet;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConversionSheetRequest;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\Unit;
use App\Project;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class BoqCivilConversionSheetController extends Controller {
    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Project $project ): \Illuminate\View\View
	{
        $conversion_sheets = ConversionSheet::where('project_id', $project->id)
            ->with('material', 'floorProject.floor')
            ->orderBy('boq_floor_id', 'asc')
            ->latest()
            ->get();

        //dd($conversion_sheets);

		return view( 'boq.departments.civil.conversion-sheet.index', compact( 'project', 'conversion_sheets' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( Project $project ): \Illuminate\View\View
	{


		$floor_list = $project->boqCivilBudgets()->where( 'boq_floor_id', '!=', null )
			->groupBy( 'boq_floor_id' )
			->with( 'boqCivilCalcProjectFloor.boqCommonFloor' )
			->get();

		$floor_list = $floor_list->sortBy( 'boq_floor_type_id' );

//		$materials = NestedMaterial::whereNotIn( 'material_status', ['Work-Material', 'Fixed Asset'] )
//			->with( 'unit' )
//			->get();
        $materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();

		// $materials = $project->boqSupremeBudgets()->where( 'material_id', '!=', null )
		// 	->where( 'budget_type', 'material' )
		// 	->where( 'budget_for', 'civil' )
		// 	->groupBy( 'material_id' )
		// 	->with( 'nestedMaterial' )
		// 	->get();

		// $materials = BoqSupremeBudget::where( $project, 'project_id' )
		// 	->where( 'budget_for', '=', 'Civil' )
		// 	->where( 'budget_type', '!=', 'material-labour' )
		// 	->groupBy( 'material_id' )
		// 	->with( 'nestedMaterial' )
		// 	->get();
		// ->toTree();

		return view( 'boq.departments.civil.conversion-sheet.create', compact( 'project', 'floor_list', 'materials' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( ConversionSheetRequest $request, Project $project) {

		foreach ( $request->boq_floor_id as $key => $value ) {

			$attributes = [
				'project_id'      => $project->id,
				'boq_floor_id'    => $value,
				'material_id'     => $request->nested_material_id,
				'conversion_date' => $request->conversion_date,
				'boq_qty'         => $request->previous_quantity[$key],
				'changed_qty'     => $request->used_quantity[$key],
				'final_qty'       => $request->revised_quantity[$key],
				'remarks'         => $request->remarks[$key],
				'budget_type'     => $request->budget_type,
			];

			ConversionSheet::create( $attributes );

            $model = BoqSupremeBudget::where([
                ['budget_for', 'Civil'],
                ['project_id', $project->id],
                ['floor_id', $value],
                ['material_id', $attributes['material_id']],
                ['budget_type', $attributes['budget_type']]
            ])->first();

            if ($model) {
                $model->update(['quantity' => $attributes['final_qty']]);
            } else {
                BoqSupremeBudget::create([
                    'budget_for'    => 'Civil',
                    'project_id'    => $project->id,
                    'floor_id'      => $value,
                    'material_id'   => $attributes['material_id'],
                    'quantity'      => $attributes['final_qty'],
                    'budget_type'   => $request->budget_type
                ]);
            }
		}

        return redirect()->route('boq.project.departments.civil.conversion-sheets.index', $project)
                ->withMessage('Data saved successfully');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\BoqCivilRevisedSheet  $boqCivilRevisedSheet
	 * @return \Illuminate\Http\Response
	 */
	public function show( BoqCivilRevisedSheet $boqCivilRevisedSheet ) {
		//
	}


    public function edit(Project $project, $conversion_sheet)
    {
        try {
            $units = Unit::latest()->get();

            $floor_list = $project->boqCivilBudgets()->where('boq_floor_id', '!=', null)
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                ->get();

            $floor_list = $floor_list->sortBy('boq_floor_type_id');

//            $materials = $project->boqSupremeBudgets()->where('material_id', '!=', null)
//                ->where('budget_type', 'material')
//                ->orWhere('budget_type', 'material-labour')
//                ->where('budget_for', 'civil')
//                ->groupBy('material_id')
//                ->with('nestedMaterial')
//                ->get();

            $materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();


            $conversion_data = ConversionSheet::where('project_id', $project->id)
                ->where('id', $conversion_sheet)
                ->with('material.unit')
                ->first();

            return view('boq.departments.civil.conversion-sheet.edit', compact('project', 'units', 'floor_list', 'materials', 'conversion_data'));


        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }


	public function update( Project $project, ConversionSheet $conversion_sheet, ConversionSheetRequest $request ) {

        try {
            $conversion_sheet_data = ConversionSheet::findOrFail($conversion_sheet->id);

            foreach ( $request->boq_floor_id as $key => $value ) {

            $attributes = [
                'project_id'      => $project->id,
				'boq_floor_id'    => $value,
				'material_id'     => $request->nested_material_id,
				'conversion_date' => $request->conversion_date,
				'boq_qty'         => $request->previous_quantity[$key],
				'changed_qty'     => $request->used_quantity[$key],
				'final_qty'       => $request->revised_quantity[$key],
				'remarks'         => $request->remarks[$key],
            ];

            // Update or create entry in BoqSupremeBudget
            $boqSupremeBudget = BoqSupremeBudget::where([
                ['budget_for', 'Civil'],
                ['budget_type', $request->budget_type],
                ['project_id', $project->id],
                ['floor_id', $value],
                ['material_id', $attributes['material_id']]
            ])->first();

            if ($boqSupremeBudget) {
                $boqSupremeBudget->update(['quantity' => $attributes['final_qty']]);
            } else {
                BoqSupremeBudget::create([
                    'budget_for'    => 'Civil',
                    'project_id'    => $project->id,
                    'floor_id'      => $value,
                    'material_id'   => $attributes['material_id'],
                    'quantity'      => $attributes['final_qty'],
                    'budget_type'   => $request->budget_type
                ]);
            }

            // Update the Conversion Sheet data
            $conversion_sheet_data->update($attributes);
        }
        return redirect()->route('boq.project.departments.civil.conversion-sheets.index', $project)
        ->withMessage('Data updated successfully');

        }catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\BoqCivilRevisedSheet  $boqCivilRevisedSheet
	 * @return \Illuminate\Http\Response
	 */
    public function destroy(Project $project,$conversion_sheet)
    {
        $conversion_sheet = ConversionSheet::where('id', $conversion_sheet)->first();

        if($conversion_sheet){
            $boqSupremeBudget = BoqSupremeBudget::where([
                ['budget_for', 'Civil'],
                ['budget_type', $conversion_sheet['budget_type']],
                ['project_id', $project->id],
                ['floor_id', $conversion_sheet['boq_floor_id']],
                ['material_id', $conversion_sheet['material_id']]
            ])->first();

            if ($boqSupremeBudget) {
                $boqSupremeBudget->update(['quantity' => $conversion_sheet['boq_qty']]);
            }
        }
        $conversion_sheet->delete();

        return redirect()->back()->withMessage('Data deleted successfully.');
    }

	public function getUnit( Request $request ) {
		$material = NestedMaterial::where( 'id', $request->nested_material_id )
			->with( 'unit' )
			->first();

		return response()->json( [
			'nested_material' => $material,
		] );

	}

}
