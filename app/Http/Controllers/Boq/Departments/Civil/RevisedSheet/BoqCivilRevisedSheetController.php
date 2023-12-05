<?php

namespace App\Http\Controllers\Boq\Departments\Civil\RevisedSheet;

use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Project;
use PHPUnit\Exception;

class BoqCivilRevisedSheetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project) : \Illuminate\View\View
    {
        $revised_sheets = BoqCivilRevisedSheet::where('project_id', $project->id)
            ->where('budget_for', 'Civil')
            ->where('escalation_no', '!=', 0)
            ->with('material', 'floorProject.floor')
            ->orderBy('boq_floor_id', 'asc')
            ->latest()
            ->get();

        return view('boq.departments.civil.revised-sheet.index', compact('project','revised_sheets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project) : \Illuminate\View\View
    {
        $units = Unit::latest()->get();

        $floor_list = $project->boqCivilBudgets()->where('boq_floor_id', '!=', null)
            ->groupBy('boq_floor_id')
            ->with('boqCivilCalcProjectFloor.boqCommonFloor')
            ->get();

        $floor_list = $floor_list->sortBy('boq_floor_type_id');

//        $materials = $project->boqSupremeBudgets()->where('material_id', '!=', null)
//            ->where('budget_type', 'material')
//            ->orWhere('budget_type', 'material-labour')
//            ->where('budget_for', 'civil')
//            ->groupBy('material_id')
//            ->with('nestedMaterial')
//            ->get();

        $materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();

        return view('boq.departments.civil.revised-sheet.create', compact('project', 'units', 'floor_list','materials'));
    }


    public function store(Request $request)
    {
        $project = Project::find($request->project_id);
        $max_escalation_no = BoqCivilRevisedSheet::where('project_id', $project->id)->max('escalation_no');
        if($request->escalation_no < $max_escalation_no) {
            $message = "Escalation No. should be greater then " . $max_escalation_no;
            return redirect()->back()->with('error', $message);
        } else {

            //foreach $request->boq_floor_id as $key => $value
            foreach ($request->boq_floor_id as $key => $value) {

                $previousEscalationData = BoqCivilRevisedSheet::where('project_id', $project->id)
                    ->where('boq_floor_id', $value)
                    ->where('nested_material_id', $request->nested_material_id)
                    ->latest()
                    ->first();

                if(!$previousEscalationData){
                    return redirect()->back()->with('error', 'You have not any previous escalation');
                }

                $previousEscalationData['used_qty'] = $previousEscalationData->current_balance_qty - $request->primary_qty[$key];
                $previousEscalationData->save();

                $project->boqRevisedBudgets()->updateOrCreate(
                    [
                        'boq_floor_id'           => $value,
                        'nested_material_id'     => $request->nested_material_id,
                        'budget_for'             => 'Civil',
                        'escalation_no'          => $request->escalation_no,
                    ],
                    [
                        'project_id'             => $project->id,
                        'budget_type'            => $request->budget_type,
                        'boq_floor_id'           => $value,
                        'nested_material_id'     => $request->nested_material_id,
                        'escalation_no'          => $request->escalation_no,
                        'escalation_date'        => now(),
                        'till_date'              => $request->till_date[$key],
                        'budget_for'             => 'Civil',
                        'primary_qty'            => $request->primary_qty[$key],
                        'primary_price'          => $request->primary_price[$key],
                        'primary_amount'         => $request->primary_qty[$key] * $request->primary_price[$key],
                        'used_qty'               => 0,
                        'current_balance_qty'    => $request->primary_qty[$key],
                        'revised_qty'            => 0,
                        'revised_price'          => $request->revised_price[$key],
                        'price_after_revised'    => $request->primary_price[$key] + $request->revised_price[$key],
                        'qty_after_revised'      => $request->primary_qty[$key] + 0,
                        'amount_after_revised'   => ($request->primary_qty[$key] + 0) * ($request->primary_price[$key] + $request->revised_price[$key]),
                        'increased_or_decreased_amount' => ($request->primary_qty[$key] + 0) * $request->revised_price[$key],
                        'remarks'                => $request->remarks[$key],
                    ]
                );

                //update supreme budget
//                $supremeBudget = BoqSupremeBudget::where('project_id', $project->id)
//                    ->where('material_id', $request->nested_material_id)
//                    ->where('floor_id', $value)
//                    ->where('budget_for', 'civil')
//                    ->where('budget_type',$request->budget_type)
//                    ->first();
//                if($supremeBudget){
//                    $supremeBudget['quantity'] = $supremeBudget->quantity + 0;
//                    $supremeBudget->save();
//                }
                //update supreme budget

            }
            return redirect()->back()->withMessage('Data saved successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BoqCivilRevisedSheet  $boqCivilRevisedSheet
     * @return \Illuminate\Http\Response
     */
    public function show(BoqCivilRevisedSheet $boqCivilRevisedSheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoqCivilRevisedSheet $boqCivilRevisedSheet, Project $project, $revised_sheet)
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


            $revised_data = BoqCivilRevisedSheet::where('project_id', $project->id)
                ->where('id', $revised_sheet)
                ->with('material.unit')
                ->first();

            return view('boq.departments.civil.revised-sheet.edit', compact('project', 'units', 'floor_list', 'materials', 'revised_data'));


        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, BoqCivilRevisedSheet $boqCivilRevisedSheet)
    {

        $project = Project::find($request->project_id);
        $max_escalation_no = BoqCivilRevisedSheet::where('project_id', $project->id)
            ->max('escalation_no');
//        if($request->escalation_no < $max_escalation_no) {
//            $message = "Escalation No. should be greater then " . $max_escalation_no;
//            return redirect()->back()->with('error', $message);
//        } else {
//
//
//        }

        //foreach $request->boq_floor_id as $key => $value
        foreach ($request->boq_floor_id as $key => $value) {

            $previousEscalationData = BoqCivilRevisedSheet::where('project_id', $project->id)
                ->where('boq_floor_id', $value)
                ->where('nested_material_id', $request->nested_material_id)
                ->latest()
                ->first();

            if(!$previousEscalationData){
                return redirect()->back()->with('error', 'You have not any previous escalation');
            }

            $previousEscalationData['used_qty'] = $previousEscalationData->current_balance_qty - $request->primary_qty[$key];
            $previousEscalationData->save();

            $project->boqRevisedBudgets()->updateOrCreate(
                [
                    'boq_floor_id'           => $value,
                    'nested_material_id'     => $request->nested_material_id,
                    'budget_for'             => 'Civil',
                    'escalation_no'          => $request->escalation_no,
                ],
                [
                    'project_id'             => $project->id,
                    'budget_type'            => $request->budget_type,
                    'boq_floor_id'           => $value,
                    'nested_material_id'     => $request->nested_material_id,
                    'escalation_no'          => $request->escalation_no,
                    'escalation_date'        => now(),
                    'till_date'              => $request->till_date[$key],
                    'budget_for'             => 'Civil',
                    'primary_qty'            => $request->primary_qty[$key],
                    'primary_price'          => $request->primary_price[$key],
                    'primary_amount'         => $request->primary_qty[$key] * $request->primary_price[$key],
                    'used_qty'               => 0,
                    'current_balance_qty'    => $request->primary_qty[$key],
                    'revised_qty'            => 0,
                    'revised_price'          => $request->revised_price[$key],
                    'price_after_revised'    => $request->primary_price[$key] + $request->revised_price[$key],
                    'qty_after_revised'      => $request->primary_qty[$key] + 0,
                    'amount_after_revised'   => ($request->primary_qty[$key] + 0) * ($request->primary_price[$key] + $request->revised_price[$key]),
                    'increased_or_decreased_amount' => ($request->primary_qty[$key] + 0) * $request->revised_price[$key],
                    'remarks'                => $request->remarks[$key],
                ]
            );

            //update supreme budget
            $supremeBudget = BoqSupremeBudget::where('project_id', $project->id)
                ->where('material_id', $request->nested_material_id)
                ->where('floor_id', $value)
                ->where('budget_for', 'civil')
                ->where('budget_type',$request->budget_type)
                ->first();
            if($supremeBudget){
                $supremeBudget['quantity'] = $supremeBudget->quantity + 0;
                $supremeBudget->save();
            }
            //update supreme budget

        }
        return redirect()->back()->withMessage('Data Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BoqCivilRevisedSheet  $boqCivilRevisedSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoqCivilRevisedSheet $boqCivilRevisedSheet, Project $project,$revised_sheet)
    {
        $revised_data = BoqCivilRevisedSheet::where('id', $revised_sheet)->delete();
        return redirect()->back()->withMessage('Data deleted successfully.');
    }
}
