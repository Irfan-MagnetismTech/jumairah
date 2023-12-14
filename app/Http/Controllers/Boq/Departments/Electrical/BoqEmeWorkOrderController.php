<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\BoqEmeWorkOrder;
use App\Boq\Departments\Eme\BoqEmeWorkSpecification;

class BoqEmeWorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-work-order-view|boq-eme-work-order-create|boq-eme-work-order-edit|boq-eme-work-order-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-work-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-work-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-work-order-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $workorders = BoqEmeWorkOrder::with('workSpecification')->latest()->get();
        return view('eme.work-order.index', compact('workorders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('eme.work-order.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWorkorderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $workorderData = $request->only('issue_date', 'boq_eme_cs_id', 'workorder_for', 'workorder_no', 'supplier_id', 'deadline', 'remarks', 'description', 'involvement', 'workrate', 'total_amount', 'project_id');
            $workorderData['prepared_by'] = auth()->id();

            DB::transaction(function () use ($workorderData, &$workorder) {
                $workorder = BoqEmeWorkOrder::create($workorderData);
            });
            return redirect()->route('eme.workorder.terms', ['workorder' => $workorder->id])->with('message', 'Data has been inserted successfully');
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
    public function show(BoqEmeWorkOrder $workorder)
    {
        return view('eme.work-order.show', compact('workorder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function edit(BoqEmeWorkOrder $work_order)
    {
        $formType = 'edit';
        return view('eme.work-order.create', compact('formType', 'work_order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkorderRequest  $request
     * @param  \App\Billing\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoqEmeWorkOrder $work_order)
    {
        // dd($request->all());
        try {
            $workorderData = $request->only('issue_date', 'boq_eme_cs_id', 'workorder_for', 'workorder_no', 'supplier_id', 'deadline', 'remarks', 'description', 'involvement', 'workrate', 'total_amount', 'project_id');
            $workorderData['prepared_by'] = auth()->id();

            DB::transaction(function () use ($workorderData, $work_order) {
                $work_order->update($workorderData);
            });
            return redirect()->route('eme.work_order.index', ['work_order' => $work_order->id])->with('message', 'Data has been updated successfully');
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
    public function destroy(BoqEmeWorkOrder $work_order)
    {
        try {
            $work_order->delete();
            return redirect()->route('eme.work_order.index', ['workorder' => $work_order->id])->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('eme.work_order.index', ['workorder' => $work_order->id])->withErrors($e->getMessage());
        }
    }

    public function technical_specification(BoqEmeWorkOrder $workorder)
    {
        return view('eme.work-order.technical_specification', compact('workorder'));
    }

    public function storeTechnical_specification(Request $request, BoqEmeWorkOrder $workorder)
    {
        try {
            DB::beginTransaction();
            $workorder->workSpecification()->delete();
            foreach ($request->workgroup as $group) {
                $schedule = BoqEmeWorkSpecification::create([
                    'boq_eme_work_order_id' => $workorder->id,
                    'topic' => $group['topic']
                ]);
                $lines = [];
                foreach ($group['title'] as $key => $status) {
                    // dd($status);
                    $lines[] = [
                        'boq_eme_work_specification_id' => $schedule->id,
                        'title' => $group['title'][$key],
                        'value' => $group['value'][$key],
                    ];
                }
                $schedule->workSpecificationLine()->createMany($lines);
            }
            DB::commit();
            return redirect()->route('eme.workorder.other_feature', ['workorder' => $workorder->id])->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function terms(BoqEmeWorkOrder $workorder)
    {
        return view('eme.work-order.terms', compact('workorder'));
    }

    public function storeTerms(Request $request, BoqEmeWorkOrder $workorder)
    {
        try {
            $termsData = $request->only('general_terms', 'payment_terms');
            $termsData['boq_eme_work_order_id'] = $workorder->id;
            $workorder->terms()->updateOrCreate(['boq_eme_work_order_id' => $workorder->id], $termsData);
            return redirect()->route('eme.workorder.technical_specification', ['workorder' => $workorder->id])->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function other_feature(BoqEmeWorkOrder $workorder)
    {
        return view('eme.work-order.others_feature', compact('workorder'));
    }

    public function storeOther_feature(Request $request, BoqEmeWorkOrder $workorder)
    {
        try {
            $termsData = $request->only('special_function', 'safety_feature');
            $termsData['boq_eme_work_order_id'] = $workorder->id;
            $workorder->workOtherFeature()->updateOrCreate(['boq_eme_work_order_id' => $workorder->id], $termsData);
            return redirect()->route('eme.work_order.index', ['workorder' => $workorder->id])->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf($workorder)
    {
        $workorder = BoqEmeWorkOrder::findOrFail($workorder);
        // return view('eme.work-order.pdf', compact('workorder'));
        return \PDF::loadview('eme.work-order.pdf', compact('workorder'))->stream('billing.workorder.pdf');
        // return view('billing.workorders.pdf', compact('workorder'));
    }
    public function Approve($BoqEmeWorkOrderId, $status)
    {
        try {
            $BoqEmeWorkOrder = BoqEmeWorkOrder::findOrFail($BoqEmeWorkOrderId);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeWorkOrder) {
                $q->where([['name', 'BOQ EME WORK ORDER'], ['department_id', $BoqEmeWorkOrder->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeWorkOrder) {
                $q->where('approvable_id', $BoqEmeWorkOrder->id)
                    ->where('approvable_type', BoqEmeWorkOrder::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeWorkOrder) {
                $q->where([['name', 'BOQ EME WORK ORDER'], ['department_id', $BoqEmeWorkOrder->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeWorkOrder) {
                $q->where('approvable_id', $BoqEmeWorkOrder->id)
                    ->where('approvable_type', BoqEmeWorkOrder::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($BoqEmeWorkOrder, $data, $check_approval) {
                $approvalData = $BoqEmeWorkOrder->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('eme.work_order.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
