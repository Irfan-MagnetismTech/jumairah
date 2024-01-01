<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Calculations;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Procurement\NestedMaterial;
use App\Http\Controllers\Controller;
use App\Procurement\BoqSupremeBudget;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use App\Boq\Departments\Eme\BoqEmeRate;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\EmeBudgetHead;
use App\Boq\Departments\Eme\BoqEmeCalculation;
use App\Http\Requests\Boq\Eme\BoqEmeCalculationRequest;
use Barryvdh\DomPDF\Facade as PDF;

class BoqElectricalCalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-budget-details-view|boq-eme-budget-details-create|boq-eme-budget-details-edit|boq-eme-budget-details-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-budget-details-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-budget-details-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-budget-details-delete', ['only' => ['destroy']]);
    }

    public function index(Project $project)
    {
        $budgetHeadId = request()->budget_head_id;
        $itemId = request()->item_id;

        $query = BoqEmeCalculation::with(['BoqFloorProject', 'NestedMaterial', 'NestedMaterialSecondLayer', 'BoqEmeRate', 'EmeBudgetHead'])
            ->where('project_id', $project->id);

        if (!empty($itemId)) {
            $query->where([['item_id', $itemId], ['budget_head_id', $budgetHeadId]]);
        } elseif (!empty($budgetHeadId)) {
            $query->where([['budget_head_id', $budgetHeadId]]);
        }

        $BoqEmeCalculations = $query->get()->groupBy(['budget_head_id', 'floor_id', 'item_id', 'material_id']);

        $boqEmeRates = BoqEmeRate::groupBy('parent_id_second')->get();
        $EmeBudgetHeads = EmeBudgetHead::get();

        return view('boq.departments.electrical.calculations.index', compact('project', 'BoqEmeCalculations', 'boqEmeRates', 'EmeBudgetHeads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $formType = "create";
        $boqEmeRates = BoqEmeRate::groupBy('parent_id_second')->get();
        $EmeBudgetHeads = EmeBudgetHead::get();
        return view('boq.departments.electrical.calculations.create', compact('project', 'boqEmeRates', 'formType', 'EmeBudgetHeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqEmeCalculationRequest $request, Project $project)
    {
        try {
            $BoqEmeCalculation = array();
            foreach ($request->material_id as  $key => $data) {
                $BoqEmeCalculation[] = [
                    'project_id'            =>  $project->id,
                    'budget_head_id'        =>  $request->budget_head_id,
                    'item_id'               =>  $request->item_id,
                    'floor_id'              =>  $request->floor_id[$key],
                    'boq_eme_rate_id'       =>  $request->boq_eme_rate_id[$key],
                    'material_id'           =>  $request->material_id[$key],
                    'material_rate'         =>  $request->material_rate[$key],
                    // 'labour_rate'           =>  $request->labour_rate[$key],
                    'quantity'              =>  $request->quantity[$key],
                    'total_material_amount' =>  $request->total_material_amount[$key],
                    // 'total_labour_amount'   =>  $request->total_labour_amount[$key],
                    // 'total_amount'          =>  $request->total_amount[$key],
                    'remarks'               =>  $request->remarks[$key],
                    'applied_by'            => auth()->id(),
                    'created_at'            =>  now()
                ];
                $materialbudgetdetails_data[] = [
                    'budget_for'            =>  "EME",
                    'project_id'            =>  $project->id,
                    'floor_id'              =>  $request->floor_id[$key],
                    'material_id'           =>  $request->material_id[$key],
                    'quantity'              =>  $request->quantity[$key],
                    'created_at'            =>  now()
                ];
            }

            DB::transaction(function () use ($BoqEmeCalculation, $materialbudgetdetails_data, $project, $request) {
                BoqEmeCalculation::insert($BoqEmeCalculation);

                foreach ($materialbudgetdetails_data as $key => $value) {
                    $model = BoqSupremeBudget::where([['budget_for', "EME"], ['project_id', $project->id], ['floor_id', $materialbudgetdetails_data[$key]['floor_id']], ['material_id', $materialbudgetdetails_data[$key]['material_id']]])->first();

                    BoqEmeRate::where('id', $request->boq_eme_rate_id[$key])->update(['labour_rate' => $request->material_rate[$key]]);

                    if ($model) {
                        $quantity = $model['quantity'] + $materialbudgetdetails_data[$key]['quantity'];
                        $model->update(['quantity' => $quantity]);
                    } else {
                        BoqSupremeBudget::insert($materialbudgetdetails_data[$key]);
                    }
                }
            });

            return redirect()->route('boq.project.departments.electrical.calculations.index', $project)->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, $BoqEmeCalculationId)
    {
        $formType = 'edit';
        $BoqEmeDatas =  BoqEmeCalculation::findOrFail($BoqEmeCalculationId);
        $boqEmeRates = BoqEmeRate::groupBy('parent_id_second')->get();
        $EmeBudgetHeads = EmeBudgetHead::get();
        return view('boq.departments.electrical.calculations.create', compact('project', 'BoqEmeDatas', 'BoqEmeCalculationId', 'formType', 'boqEmeRates', 'EmeBudgetHeads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, $BoqEmeCalculationId)
    {
        try {
            $BoqEmeCalculationDatas =  BoqEmeCalculation::findOrFail($BoqEmeCalculationId);
            $BoqEmeCalculation = array();
            foreach ($request->material_id as  $key => $data) {
                $BoqEmeCalculation = [
                    'budget_head_id'        =>  $request->budget_head_id,
                    'item_id'               =>  $request->item_id,
                    'floor_id'              =>  $request->floor_id[$key],
                    'boq_eme_rate_id'       =>  $request->boq_eme_rate_id[$key],
                    'material_id'           =>  $request->material_id[$key],
                    'material_rate'         =>  $request->material_rate[$key],
                    // 'labour_rate'           =>  $request->labour_rate[$key],
                    'quantity'              =>  $request->quantity[$key],
                    'total_material_amount' =>  $request->total_material_amount[$key],
                    // 'total_labour_amount'   =>  $request->total_labour_amount[$key],
                    // 'total_amount'          =>  $request->total_amount[$key],
                    'remarks'               =>  $request->remarks[$key],
                    'updated_at'            =>  now()
                ];
            }
            $BoqSupremeBudget = BoqSupremeBudget::where([
                'budget_for' => "EME",
                'project_id' => $project->id,
                'floor_id' => $request->floor_id[0],
                'material_id' => $request->material_id[0],
            ])->get()->first();

            $quantity = ($BoqSupremeBudget['quantity'] - $BoqEmeCalculationDatas['quantity']) + $BoqEmeCalculation['quantity'];

            DB::transaction(function () use ($BoqEmeCalculation, $BoqEmeCalculationDatas, $quantity, $BoqSupremeBudget, $request) {
                $BoqEmeCalculationDatas->update($BoqEmeCalculation);
                $BoqSupremeBudget->update(['quantity' => $quantity]);
                BoqEmeRate::where('id', $request->boq_eme_rate_id[0])->update(['labour_rate' => $request->material_rate[0]]);
            });

            return redirect()->route('boq.project.departments.electrical.calculations.index', $project)->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $BoqEmeCalculationId)
    {

        try {
            DB::beginTransaction();
            $BoqEmeDatas =  BoqEmeCalculation::findOrFail($BoqEmeCalculationId);
            $BoqSupremeBudget = BoqSupremeBudget::where([
                'project_id' => $project->id,
                'budget_for' => "EME",
                'floor_id' => $BoqEmeDatas->floor_id,
                'material_id' => $BoqEmeDatas->material_id,
            ])->get()->first();

            $quantity = $BoqSupremeBudget['quantity'] - $BoqEmeDatas['quantity'];

            if ($BoqSupremeBudget) {
                $quantity = $BoqSupremeBudget['quantity'] - $BoqEmeDatas['quantity'];
                if ($quantity > 0) {
                    $BoqSupremeBudget->update(['quantity' => $quantity]);
                } else {
                    $BoqSupremeBudget->delete();
                }
            }

            $BoqEmeDatas->delete();
            DB::commit();
            return redirect()->route('boq.project.departments.electrical.calculations.index', $project)->with('message', 'Data has been Deleted successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function getMaterialUnitById(Request $request)
    {
        $unit = NestedMaterial::where('id', $request->material_id)->with('unit')->first();
        return $unit;
    }

    public function Approve(Project $project, $BoqEmeCalculationId, $status)
    {
        try {
            $BoqEmeCalculation = BoqEmeCalculation::findOrFail($BoqEmeCalculationId);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeCalculation) {
                $q->where([['name', 'BOQ EME ITEM CALCULATION'], ['department_id', $BoqEmeCalculation->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeCalculation) {
                $q->where('approvable_id', $BoqEmeCalculation->id)
                    ->where('approvable_type', BoqEmeCalculation::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeCalculation) {
                $q->where([['name', 'BOQ EME ITEM CALCULATION'], ['department_id', $BoqEmeCalculation->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeCalculation) {
                $q->where('approvable_id', $BoqEmeCalculation->id)
                    ->where('approvable_type', BoqEmeCalculation::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($BoqEmeCalculation, $data, $check_approval) {
                $approvalData = $BoqEmeCalculation->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('boq.project.departments.electrical.calculations.index', $project)->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    public function pdf(Project $project)
    {

        $data = BoqEmeCalculation::with(['BoqFloorProject', 'NestedMaterial', 'NestedMaterialSecondLayer', 'BoqEmeRate', 'EmeBudgetHead'])->where('project_id', $project->id)->get();

        $dataFiltered = $data->filter(function ($item) {

            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
                $q->where('name', 'BOQ EME ITEM CALCULATION');
            })->orderBy('order_by', 'desc')->get();
            $count = $item->approval->count();
            $data = $item->approval;
            if ($count == 0) {
                return false;
            }
            return (($data->last()->layer_key) == ($check_approval[0]->layer_key));
        });
        $BoqEmeCalculations = $dataFiltered->groupBy(['budget_head_id', 'floor_id', 'item_id', 'material_id']);
        $pdf = PDF::loadview('boq.departments.electrical.calculations.pdf', compact('BoqEmeCalculations', 'project'))->setPaper('A4', 'landscape');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.15, "Multiply");

        $canvas->page_text(
            $width / 3,
            $height / 2,
            'Jumairah Holdings',
            null,
            55,
            array(0, 0, 0),
            2,
            2,
            -30
        );
        return $pdf->stream('calculation.pdf');
    }
}
