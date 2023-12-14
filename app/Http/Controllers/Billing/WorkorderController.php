<?php

namespace App\Http\Controllers\Billing;

use App\Approval\Approval;
use App\Billing\Workorder;
use App\Billing\WorkorderTerms;
use App\Billing\WorkorderSchedule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Billing\ProjectWiseWorkOrder;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request as HttpRequest;
use App\Http\Requests\StoreWorkorderRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Services\UniqueNoGenaratorService;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $uniqueNoGenarate;
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:work-order-view|work-order-create|work-order-edit|work-order-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:work-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:work-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:work-order-delete', ['only' => ['destroy']]);
        $this->uniqueNoGenarate = new UniqueNoGenaratorService();
    }

    public function index()
    {
        $workorders = Workorder::with('workorderRates')->latest()->get();
        return view('billing.workorders.index', compact('workorders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = [];
        $formType = 'create';
        return view('billing.workorders.create', compact('suppliers', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWorkorderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkorderRequest $request)
    {
        try {
            $workorderData = $request->only('issue_date', 'work_cs_id', 'supplier_id', 'deadline', 'remarks', 'description', 'involvement', 'project_id');
            $workorderData['prepared_by'] = auth()->id();
            $workorderData['workorder_no'] = $this->uniqueNoGenarate->generateUniqueNo(Workorder::class, 'Workorder', 'project_id', $request->project_id, 'workorder_no');
            $workorderRatesData = array();
            foreach ($request->work_level as  $key => $data) {
                $workorderRatesData[] = [
                    'work_level' => $request->work_level[$key],
                    'work_description' => $request->work_description[$key],
                    'work_quantity' => $request->work_quantity[$key],
                    'work_unit' => $request->work_unit[$key],
                    'work_rate' => $request->work_rate[$key],
                ];
            }
            // dd($workorderRatesData);

            DB::transaction(function () use ($workorderData, $workorderRatesData, &$workorder) {
                $workorder = Workorder::create($workorderData);
                $workorder->workorderRates()->createMany($workorderRatesData);
            });
            return redirect()->route('workorder-payments', $workorder->id)->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function show(Workorder $workorder)
    {
        return view('billing.workorders.show', compact('workorder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function edit(Workorder $workorder)
    {
        $suppliers = [];
        $formType = 'edit';
        return view('billing.workorders.create', compact('suppliers', 'workorder', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkorderRequest  $request
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWorkorderRequest $request, Workorder $workorder)
    {
        try {
            $workorderData = $request->only('issue_date', 'work_cs_id', 'supplier_id', 'deadline', 'remarks', 'description', 'involvement', 'project_id');
            if (($request->project_id != $workorder->project_id) || $request->workorder_no == null){
                $workCData['workorder_no'] = $this->uniqueNoGenarate->generateUniqueNo(Workorder::class, 'Workorder', 'project_id', $request->project_id, 'workorder_no');
            }
            $workorderRatesData = array();
            foreach ($request->work_level as  $key => $data) {
                $workorderRatesData[] = [
                    'work_level' => $request->work_level[$key],
                    'work_description' => $request->work_description[$key],
                    'work_quantity' => $request->work_quantity[$key],
                    'work_unit' => $request->work_unit[$key],
                    'work_rate' => $request->work_rate[$key],
                ];
            }

            // dd($workorderData);
            DB::transaction(function () use ($workorderData, $workorder, $workorderRatesData) {
                $workorder->update($workorderData);
                $workorder->workorderRates()->delete();
                $workorder->workorderRates()->createMany($workorderRatesData);
            });
            return redirect()->route('workorders.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workorder $workorder)
    {
        try {
            $workorder->delete();
            return redirect()->route('workorders.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('workorders.index')->withErrors($e->getMessage());
        }
    }

    public function payment(Workorder $workorder)
    {
        return view('billing.workorders.payments', compact('workorder'));
    }

    public function storePayment(HttpRequest $request, Workorder $workorder)
    {
        try {
            $workorder->workOrderSchedules()->delete();
            foreach ($request->workgroup as $group) {
                $schedule = WorkorderSchedule::create([
                    'workorder_id' => $workorder->id,
                    'rs_title' => $group['rs_title']
                ]);
                $lines = [];
                foreach ($group['work_status'] as $key => $status) {
                    // dd($status);
                    $lines[] = [
                        'workorder_schedule_id' => $schedule->id,
                        'work_status' => $group['work_status'][$key],
                        'payment_ratio' => $group['payment_ratio'][$key],
                    ];
                }
                $schedule->workOrderScheduleLines()->createMany($lines);
            }
            return redirect()->route("workorder-terms", $workorder->id)->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function terms(Workorder $workorder)
    {
        return view('billing.workorders.terms', compact('workorder'));
    }

    public function storeTerms(HttpRequest $request, Workorder $workorder)
    {
        try {
            $termsData = $request->only('general_terms', 'payment_terms');
            $termsData['workorder_id'] = $workorder->id;
            $workorder->terms()->updateOrCreate(['workorder_id' => $workorder->id], $termsData);
            return redirect()->route('workorders.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf(Workorder $workorder)
    {

        $workorder->load('appliedBy.employee');
        $approvals = Approval::query()->with(['user.employee', 'approvalLayerDetails'])->where('approvable_id', $workorder->id)->where('approvable_type', Workorder::class)->get();

        return \PDF::loadview('billing.workorders.pdf', compact('approvals','workorder'))->stream('billing.workorder.pdf');
        // return view('billing.workorders.pdf', compact('workorder'));
    }

    public function Approve(Workorder $workorder, $status)
    {
        try {
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workorder) {
                $q->where([['name', 'WORK ORDER'], ['department_id', $workorder->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($workorder) {
                $q->where('approvable_id', $workorder->id)
                    ->where('approvable_type', Workorder::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workorder) {
                $q->where([['name', 'WORK ORDER'], ['department_id', $workorder->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($workorder) {
                $q->where('approvable_id', $workorder->id)
                    ->where('approvable_type', Workorder::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($workorder, $data, $check_approval) {
                $approvalData = $workorder->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                    // $year = $this->formatDate($workorder->issue_date);
                    // $project_short_name = $workorder->project->shortName;
                    // $is_exist_projectwise_iou_date = ProjectWiseWorkOrder::query()->where('project_id', $workorder->project_id)->first();

                    // $projectWiseData = ProjectWiseWorkOrder::updateOrCreate(
                    //     [
                    //         'project_id' => $workorder->project_id
                    //     ],
                    //     [
                    //         'project_id' => $workorder->project_id,
                    //         'project_wise_workorder' => $is_exist_projectwise_iou_date ? $is_exist_projectwise_iou_date->project_wise_workorder + 1 : 1
                    //     ]
                    // );
                    // $pieces = explode(" ", $workorder->workCs->cs_type);
                    // array_pop($pieces);
                    // $work_type = implode("_", $pieces);
                    // $wo_string_name = $project_short_name . '-' . 'WO' . '-' . $projectWiseData->project_wise_workorder . '-' . $work_type . "-" . $year;
                    // $workorder->update(['workorder_no' => $wo_string_name]);
                }
            });
            return redirect()->route('workorders.index')->with('message', 'Data has been approved successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    private function formatDate(string $date): string
    {
        return substr(date_format(date_create($date), "y"), 0);
    }
}
