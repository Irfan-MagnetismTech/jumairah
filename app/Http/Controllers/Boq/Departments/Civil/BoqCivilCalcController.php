<?php

namespace App\Http\Controllers\Boq\Departments\Civil;

use App\Boq\Configurations\BoqFloorType;
use App\Boq\Configurations\BoqMaterialFormula;
use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Configurations\BoqReinforcementMeasurement;
use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Boq\Departments\Civil\BoqCivilCalcGroup;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Http\Services\CivilCalcService;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoqCivilCalcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project, $calculation_type)
    {
        $nodes = BoqWork::get()->toTree();

        $boq_floors = $project->boqFloorProjects()->with('boqCommonFloor', 'floor.floor_type')
            ->get()
            ->sortBy('floor.floor_type.serial_no');

        $boq_works = [];
        $traverse  = function ($all_boq_works, $prefix = '-') use (&$traverse, &$boq_works)
        {
            foreach ($all_boq_works as $boq_work)
            {
                $boq_works[$boq_work->id] = $prefix . ' ' . $boq_work->name;

                $traverse($boq_work->children, $prefix . '-');
            }
        };

        $traverse($nodes);

        if ($request->work_id != '' && $request->boq_floor_project_id != '')
        {
            $calculations = BoqCivilCalc::where('project_id', $project->id)->where('work_id', $request->work_id)
                ->where('boq_floor_id', $request->boq_floor_project_id)->where('calculation_type', $calculation_type)
                ->with('boqCivilCalcGroups', 'boqCivilCalcDetails')
                ->first();
        }
        else
        {
            $calculations = null;
        }

        return view('boq.departments.civil.calculation.record', compact('project', 'calculation_type',
            'boq_works', 'boq_floors', 'calculations'));
    }

    /**
     * @param Project $project
     * @param $calculation_type
     */
    public function create(Project $project, $calculation_type)
    {
        try {

            $total_area = $project->boqFloorProjects()->sum('area');

            if ((int) $total_area === 0)
            {
                return redirect()->route('boq.project.configurations.areas.index', ['project' => $project->id])
                    ->withError('Please add area for project');
            }


            $labour_calculations = [];
            $nested_materials = NestedMaterial::get()->toTree();

            $boq_reinforcement_measurements = BoqReinforcementMeasurement::orderBy('dia')->get();

            $boq_works        = BoqWork::get()->toTree();

            //filter boq floor type for calculation type
            if($calculation_type == 'material'){
                $boq_floor_types = BoqFloorType::where('show_for_material', 1)->orderBy('serial_no')->get();
            } elseif ($calculation_type == 'labour'){
                $boq_floor_types = BoqFloorType::where('show_for_labour', 1)->orderBy('serial_no')->get();
            } elseif ($calculation_type == 'material-labour'){
                $boq_floor_types = BoqFloorType::where('show_for_material_labour', 1)->orderBy('serial_no')->get();
            } else {
                $boq_floor_types = BoqFloorType::orderBy('serial_no')->all();
            }

            //$boq_floor_types  = BoqFloorType::all();

            $is_reinforcement = 0;
            $measurement_keys = $boq_reinforcement_measurements->pluck('weight', 'id');

            return view('boq.departments.civil.calculation.create', compact(
                'project',
                'calculation_type',
                'nested_materials',
                'boq_works',
                'boq_reinforcement_measurements',
                'measurement_keys',
                'is_reinforcement',
                'boq_floor_types',
                'labour_calculations'
            ));
        }
        catch (\Exception$e)
        {

            return redirect()->back()->withInput()->withError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, $calculation_type)
    {

        try
        {
            DB::transaction(function () use ($request, $project, $calculation_type)
            {
                $civil_calc = new CivilCalcService($request, $project, $calculation_type);
                $civil_calc->handleCalculation();
                $civil_calc->handleBudget();

                $findWork = BoqWork::find($request->work_id);

                if($findWork->is_reinforcement == 1){
                    $civil_calc->reinforcementCalculation();
                }
            });

            return response()->json([
                'status'  => $request->all(),
                'message' => 'Calculation saved successfully.',
            ], 200);
        }
        catch (\Exception$e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, $calculation_type, $calculation)
    {

        try {
            $boq_reinforcement_measurements = BoqReinforcementMeasurement::orderBy('dia')->get();
            $measurement_keys = $boq_reinforcement_measurements->pluck('weight', 'id');

            $boq_civil_budghet = BoqCivilBudget::where('project_id', $project->id)->where('budget_type', $calculation_type)
                ->with('boqWork','boqCivilCalcFloorType','boqParentWork','boqFloorProject.boqCommonFloor')->find($calculation);

            if(!$boq_civil_budghet){
                return redirect()->route('boq.project.departments.civil.calculations.create', ['project' => $project, 'calculation_type' => $calculation_type]);
            }
            //$result = BoqWork::ancestorsOf($boq_civil_budghet?->boq_work_id)->toTree();
            //$result = BoqWork::defaultOrder()->ancestorsOf($boq_civil_budghet?->boq_work_id)->toTree();
            $workTree = BoqWork::whereAncestorOrSelf($boq_civil_budghet?->boq_work_id)->get();

            $nested_materials = NestedMaterial::get()->toTree();

            $boq_reinforcement_measurements = BoqReinforcementMeasurement::orderBy('dia')->get();

            //filter boq floor type for calculation type
            if($boq_civil_budghet->budget_type == 'material'){
                $boq_floor_types = BoqFloorType::where('show_for_material', 1)->orderBy('serial_no')->get();
            } elseif ($boq_civil_budghet->budget_type == 'labour'){
                $boq_floor_types = BoqFloorType::where('show_for_labour', 1)->orderBy('serial_no')->get();
            } elseif ($boq_civil_budghet->budget_type == 'material-labour'){
                $boq_floor_types = BoqFloorType::where('show_for_material_labour', 1)->orderBy('serial_no')->get();
            } else {
                $boq_floor_types = BoqFloorType::orderBy('serial_no')->all();
            }

            return view('boq.departments.civil.calculation.calculation-edit', compact(
                'project',
                'calculation_type',
                'calculation',
                'nested_materials',
                'boq_reinforcement_measurements',
                'boq_civil_budghet',
                'boq_floor_types',
                'measurement_keys',
                'workTree'
            ));

        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, $calculation_type, BoqCivilCalcGroup $calculation)
    {
        try
        {
            DB::transaction(function () use ($request, $project, $calculation_type, $calculation)
            {
                /* Boq calculation start */
                $calculation->boqCivilCalcDetails()->delete();

                $boq_civil_calcs_details = $this->makeBoqCivilCalcsData($request->all());

                $grand_total = array_sum(array_column($boq_civil_calcs_details, 'total'));

                $boq_civil_calc = BoqCivilCalc::firstOrCreate(
                    [
                        'project_id'       => $project->id,
                        'boq_floor_id'     => $request->boq_floor_id,
                        'work_id'          => $request->work_id,
                        'calculation_type' => $calculation_type,
                    ],
                    ['total' => $grand_total] + $request->all()
                );

                $calculation->update(['total' => $grand_total, 'boq_civil_calc_id' => $boq_civil_calc->id, 'name' => $request->name]);

                $boq_civil_calcs_details = array_map(function ($item) use ($boq_civil_calc)
                {
                    return $item + ['boq_civil_calc_id' => $boq_civil_calc->id];
                }, $boq_civil_calcs_details);

                $calculation
                    ->boqCivilCalcDetails()
                    ->createMany($boq_civil_calcs_details);

                $boq_civil_calc_total = $boq_civil_calc->boqCivilCalcGroups()->sum('total');
                $boq_civil_calc->update(['total' => $boq_civil_calc_total]);
                /* Boq calculation end */

                /* Boq budget start */
                if ($calculation_type === 'labour')
                {
                    $project->boqCivilBudgets()->updateOrCreate(
                        [
                            'boq_work_id'  => $request->work_id,
                            'boq_floor_id' => $request->boq_floor_id,
                            'budget_type'  => $calculation_type,
                        ],
                        [
                            'quantity'       => $boq_civil_calc_total,
                            'total_quantity' => $boq_civil_calc_total,
                            'total_amount'   => 0,
                        ]
                    );
                }
                else
                {
                    $work              = BoqWork::find($request->work_id);
                    $material_formulas = BoqMaterialFormula::where('work_id', $request->work_id)->get();

                    if ($material_formulas === null)
                    {
                        throw new \Exception("Material formula not found for work: {$work->name}");
                    }

                    $material_price_wastages = BoqMaterialPriceWastage::where('project_id',$project->id)->whereIn('nested_material_id', $material_formulas->pluck('nested_material_id'))
                        ->get();

                    if ($material_price_wastages->count() !== $work->boqMaterialFormulas->count())
                    {
                        throw new \Exception("Material price or wastage not found for work: {$work->name}");
                    }

                    $material_price_wastages = $material_price_wastages->keyBy('nested_material_id');

                    foreach ($work->boqMaterialFormulas as $boq_material_formula)
                    {
                        $material_id = $boq_material_formula->nested_material_id;
                        $quantity    = $boq_civil_calc_total * $boq_material_formula->percentage_value;
                        $wastage     = $material_price_wastages[$material_id]->wastage;
                        $rate        = $material_price_wastages[$material_id]->price;

                        $project->boqCivilBudgets()->updateOrCreate(
                            [
                                'boq_work_id'        => $request->work_id,
                                'boq_floor_id'       => $request->boq_floor_id,
                                'nested_material_id' => $boq_material_formula->nested_material_id,
                                'budget_type'        => $calculation_type,
                            ],
                            [
                                'formula_percentage' => $boq_material_formula->percentage_value,
                                'quantity'           => $quantity,
                                'wastage'            => $wastage,
                                'rate'               => $rate,
                                'total_quantity'     => $quantity + $wastage,
                                'total_amount'       => ($quantity + $wastage) * $rate,
                            ]
                        );
                    }
                }

                /* Boq budget end */
            });

            return redirect()->route('boq.project.departments.civil.calculations.index', ['project' => $project, 'calculation_type' => $calculation_type])
                ->withInput()
                ->withMessage('Calculation edited successfully');
        }
        catch (\Exception$e)
        {

            return redirect()->back()->withInput()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $calculation_type, BoqCivilCalcGroup $calculation)
    {
        try
        {
            DB::transaction(function () use ($project, $calculation_type, $calculation)
            {
                $calculation->boqCivilCalcDetails()->delete();

                $calculation->delete();

                $boq_civil_calc        = BoqCivilCalc::find($calculation->boq_civil_calc_id)->first();
                $boq_civil_calc_groups = $boq_civil_calc->boqCivilCalcGroups()->get();

                if ($boq_civil_calc_groups->count() === 0)
                {
                    $boq_civil_calc->delete();
                    $project->boqCivilBudgets()->where('boq_floor_id', $calculation->boq_floor_id)
                        ->where('boq_work_id', $calculation->work_id)
                        ->where('budget_type', $calculation_type)
                        ->delete();
                }
                else
                {
                    $boq_civil_calc->update(['total' => $boq_civil_calc_groups->sum('total')]);
                }

                $boq_civil_calc->delete();

                $boq_civil_calc_total = $boq_civil_calc->boqCivilCalcGroups()->sum('total');
                $boq_civil_calc->update(['total' => $boq_civil_calc_total]);
            });
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withError($e->getMessage());
        }
    }

    /**
     * Structures the data for inserting
     *
     * @param array $request
     * @return mixed
     */
    private function makeBoqCivilCalcsData(array $request): array
    {
        $calculation_data = [];

        foreach ($request['no_or_dia'] as $key => $no_or_dia)
        {
            $calculation_data[] = [
                'no_or_dia'                        => $no_or_dia,
                'length'                           => $request['length'][$key],
                'height_or_bar'                    => $request['height_or_bar'][$key],
                'sub_location_name'                => $request['sub_location_name'][$key],
                'breadth_or_member'                => $request['breadth_or_member'][$key],
                'boq_reinforcement_measurement_id' => $request['boq_reinforcement_measurement_id'][$key] ?? null,
                'total'                            => $this->calculateArea(
                    $request['no_or_dia'][$key],
                    $request['length'][$key],
                    $request['breadth_or_member'][$key],
                    $request['height_or_bar'][$key]
                ),
            ];
        }

        return $calculation_data;
    }

    /**
     * Multiply the area of the given dimensions
     *
     * @param $numbers
     * @return float
     */
    private function calculateArea(...$numbers): float
    {
        $result = 1.0;

        foreach ($numbers as $number)
        {
            $result *= $number ?? 1.0;
        }

        return $result;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return mixed
     */

    public function getPreviousCalculationList(Request $request, Project $project)
    {
//        if($request->calculation_type == 'labour'){
//            $labourData = BoqCivilBudget::where('project_id', $project->id)
//                ->where('budget_type', 'labour')
//                ->where('boq_work_id', $request->work_id)
//                ->where('boq_floor_id', $request->boq_floor_id)
//                ->first();
//
//            $calculations = new \stdClass();
//            if($labourData != null){
//                $boq_work = BoqWork::find($request->work_id);
//                if($boq_work->labour_budget_type == 1){
//                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $request->boq_floor_id)->first();
//                    $calculations->quantity = $boq_floor->area;
//
//                } else{
//                    $labourDataCollect = BoqCivilCalc::where('project_id', $project->id)
//                        ->where('calculation_type', 'material')
//                        ->where('work_id', $request->work_id)
//                        ->where('boq_floor_id', $request->boq_floor_id)
//                        ->first();
//
//                    $calculations->quantity = ($labourDataCollect->total > 0) ? $labourDataCollect->total : $labourDataCollect->secondary_total;
//                }
//
//                $calculations->id = $labourData->id;
//                $calculations->rate = $labourData->rate;
//                $calculations->total_amount = $labourData->total_amount;
//
//            } else{
//                $boq_work = BoqWork::find($request->work_id);
//                if($boq_work->labour_budget_type == 1){
//                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $request->boq_floor_id)->first();
//                    $calculations->quantity = $boq_floor->area;
//
//                } else{
//                    $labourDataCollect = BoqCivilCalc::where('project_id', $project->id)
//                        ->where('calculation_type', 'material')
//                        ->where('work_id', $request->work_id)
//                        ->where('boq_floor_id', $request->boq_floor_id)
//                        ->first();
//
//                    $calculations->quantity = ($labourDataCollect->total > 0) ? $labourDataCollect->total : $labourDataCollect->secondary_total;
//                }
//
//                $calculations->rate = 0;
//                $calculations->total_amount = 0;
//            }
//
//        } else{
//
//            $calculations = BoqCivilCalc::where('project_id', $project->id)
//                ->where('work_id', $request->work_id)
//                ->where('boq_floor_id', $request->boq_floor_id)
//                ->where('calculation_type', $request->calculation_type)
//                ->with('boqCivilCalcGroups.boqCivilCalcDetails.boqReinforcementMeasurement')
//                ->first();
//
//        }
        $calculations = BoqCivilCalc::where('project_id', $project->id)
            ->where('work_id', $request->work_id)
            ->where('boq_floor_id', $request->boq_floor_id)
            ->where('calculation_type', $request->calculation_type)
            ->with('boqCivilCalcGroups.boqCivilCalcDetails.boqReinforcementMeasurement','boqCivilCalcGroups.boqCivilCalcGroupMaterials.boqCivilCalcGroupMaterial')
            ->first();
        return $calculations;
    }


    public function getPreviousMaterialList(Request $request, Project $project)
    {
        $materials = $project->boqCivilBudgets()->where('boq_work_id', $request->work_id)
            ->where('boq_floor_id', $request->boq_floor_id)
            ->where('budget_type', $request->budget_type)
            ->pluck('nested_material_id')->values();

        return $materials;
    }

    public function removeBudgetFromSupremeRevised(Request $request)
    {
        $supremeBudget = BoqSupremeBudget::where('project_id',$request->project_id)
            ->where('floor_id',$request->boq_floor_id)->where('material_id',$request->material_id)->delete();

        $revisedBudget = BoqCivilRevisedSheet::where('project_id',$request->project_id)
            ->where('boq_floor_id',$request->boq_floor_id)->where('nested_material_id',$request->material_id)->delete();

        return response()->json(['success' => true, 'message' => 'Budget material removed successfully'], 200);
    }
}
