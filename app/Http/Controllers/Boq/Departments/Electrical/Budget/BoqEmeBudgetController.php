<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Budget;

use App\Project;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Boq\Projects\BoqFloorProject;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Boq\Departments\Eme\BoqEmeBudget;
use App\Boq\Departments\Eme\EmeBudgetHead;
use App\Http\Requests\Boq\Eme\BoqEmeBudgetRequest;
use Barryvdh\DomPDF\Facade as PDF;

class BoqEmeBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-budget-view|boq-eme-budget-create|boq-eme-budget-edit|boq-eme-budget-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-budget-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-budget-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-budget-delete', ['only' => ['destroy']]);
    }

    public function index(Project $project)
    {
        $BoqEmeBudgetData = BoqEmeBudget::where('project_id', $project->id)->get();
        return view('boq.departments.electrical.budget.index', compact('project', 'BoqEmeBudgetData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $EmeBudgetHeadData = EmeBudgetHead::orderBy('id')->get();
        $formType = "create";
        return view('boq.departments.electrical.budget.create', compact('project', 'formType', 'EmeBudgetHeadData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqEmeBudgetRequest $request, Project $project)
    {
        try {
            $request_data = array();
            foreach ($request->budget_head_id as  $key => $data) {
                $request_data[] = [
                    'project_id'        =>  $project->id,
                    'applied_by'        =>  auth()->id(),
                    'budget_head_id'    =>  $request->budget_head_id[$key],
                    'specification'     =>  $request->specification[$key],
                    'brand'             =>  $request->brand[$key],
                    'rate'              =>  $request->rate[$key],
                    'quantity'          =>  $request->quantity[$key],
                    'amount'            =>  $request->amount[$key],
                    'created_at'        =>  now()
                ];
            }
            DB::transaction(function () use ($request_data) {
                BoqEmeBudget::insert($request_data);
            });

            return redirect()->route('boq.project.departments.electrical.budgets.index', $project)->with('message', 'Data has been inserted successfully');
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
     * @param  int  $BoqEmeBudgetId
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, $id)
    {
        // $BoqEmeBudget = BoqEmeBudget::findOrFail($BoqEmeBudgetId);
        $BoqEmeBudget = BoqEmeBudget::where('project_id', $project->id)->get();
        $formType = "edit";
        return view('boq.departments.electrical.budget.create', compact('project', 'formType', 'BoqEmeBudget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $BoqEmeBudgetId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, $BoqEmeBudgetId)
    {
        // $BoqEmeBudget = BoqEmeBudget::where('id', $BoqEmeBudgetId)->first();
        $project_id = $project->id;
        try {
            // foreach ($request->budget_head_id as  $key => $data) {
            //     $request_data = [
            //         'project_id'        =>  $project->id,
            //         'budget_head_id'    =>  $request->budget_head_id[$key],
            //         'specification'     =>  $request->specification[$key],
            //         'brand'             =>  $request->brand[$key],
            //         'rate'              =>  $request->rate[$key],
            //         'quantity'          =>  $request->quantity[$key],
            //         'amount'            =>  $request->amount[$key],
            //         'created_at'        =>  now()
            //     ];
            // }

            // DB::transaction(function () use ($request_data, $BoqEmeBudget) {
            //     $BoqEmeBudget->update($request_data);
            // });
            DB::transaction(function () use ($request, $project_id) {
                foreach ($request->budget_head_id as $key => $data) {
                    $dataToSave = [
                        'project_id'        => $project_id,
                        'budget_head_id'    => $request->budget_head_id[$key],
                        'specification'     => $request->specification[$key],
                        'brand'             => $request->brand[$key],
                        'rate'              => $request->rate[$key] ?? 0.00,
                        'quantity'          => $request->quantity[$key] ?? 0.00,
                        'amount'            => $request->amount[$key] ?? 0.00,
                        'applied_by'        => auth()->id(),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];

                    BoqEmeBudget::updateOrInsert(
                        [
                            'project_id' => $project_id,
                            'budget_head_id' => $request->budget_head_id[$key]
                        ],
                        $dataToSave
                    );
                }
            });

            return redirect()->route('boq.project.departments.electrical.budgets.index', $project)->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $BoqEmeBudgetId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $BoqEmeBudgetId)
    {
        $BoqEmeBudget = BoqEmeBudget::where('id', $BoqEmeBudgetId)->first();
        try {
            $BoqEmeBudget->delete();
            return redirect()->route('boq.project.departments.electrical.budgets.index', $project)->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('boq.project.departments.electrical.budgets.index', $project)->withErrors($e->getMessage());
        }
    }


    public function Approve(Project $project, $BoqEmeBudgetId, $status)
    {
        try {
            $BoqEmeBudget = BoqEmeBudget::findOrFail($BoqEmeBudgetId);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeBudget) {
                $q->where([['name', 'BOQ EME BUDGET'], ['department_id', $BoqEmeBudget->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeBudget) {
                $q->where('approvable_id', $BoqEmeBudget->id)
                    ->where('approvable_type', BoqEmeBudget::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeBudget) {
                $q->where([['name', 'BOQ EME BUDGET'], ['department_id', $BoqEmeBudget->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeBudget) {
                $q->where('approvable_id', $BoqEmeBudget->id)
                    ->where('approvable_type', BoqEmeBudget::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($BoqEmeBudget, $data, $check_approval) {
                $approvalData = $BoqEmeBudget->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('boq.project.departments.electrical.budgets.index', $project)->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    public function pdf(Project $project)
    {

        $dataFiltered = BoqEmeBudget::query()->where('project_id', $project->id)->get();

        // $dataFiltered = $data->filter(function ($item) {

        //     $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
        //         $q->where('name', 'BOQ EME BUDGET');
        //     })->orderBy('order_by', 'desc')->get();
        //     $count = $item->approval->count();
        //     $data = $item->approval;
        //     if ($count == 0) {
        //         return false;
        //     }
        //     return (($data->last()->layer_key) == ($check_approval[0]->layer_key));
        // });
        $pdf = PDF::loadview('boq.departments.electrical.budget.pdf', compact('dataFiltered', 'project'))->setPaper('A4', 'portrait');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.15, "Multiply");

        $canvas->page_text(
            $width / 3,
            $height / 2,
            'Rancon FC',
            null,
            55,
            array(0, 0, 0),
            2,
            2,
            -30
        );
        return $pdf->stream('budget.pdf');
    }
}
