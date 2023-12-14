<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Http\Controllers\Controller;

use App\Http\Requests\IouRequest;
use App\Procurement\Iou;
use App\Procurement\Material;
use App\Procurement\NestedMaterial;
use App\Procurement\Requisition;
use App\Procurement\Requisitiondetails;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Procurement\PurchaseOrderDetail;
use App\Approval\ApprovalLayerDetails;
use App\Billing\Workorder;
use App\Boq\Departments\Eme\BoqEmeWorkOrder;
use App\Procurement\IouReportProjectWise;
use App\Procurement\IouReportMonthWise;
use App\CostCenter;
use Barryvdh\DomPDF\Facade as PDF;

class IouController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:iou-view|iou-create|iou-edit|iou-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:iou-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:iou-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:iou-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ious = Iou::with(['costCenter'])->latest()->get();
        return view('procurement.ious.index', compact('ious'));
    }

    public function create()
    {
        $formType = "create";
        $projects = Project::orderBy('name')->pluck('name', 'id');
        $materials = [];
        return view('procurement.ious.create', compact('formType', 'projects', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IouRequest $request)
    {
        try {
            $iouData = $request->only('cost_center_id', 'remarks', 'applied_date');
            $iouData['applied_by'] = auth()->id();
            if ($request->switch == 'supplier') {
                $iouData['supplier_id']  = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['po_no'] = $request->po_no;
                $iouData['type'] = 1;
            } elseif ($request->switch == 'employee') {
                $iouData['total_amount'] = $request->employee_total_amount;
                $iouData['requisition_id'] = $request->mpr_id;
                $iouData['type'] = 0;
            } elseif ($request->switch == 'construction') {
                $iouData['supplier_id']  = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['workorder_id']  = $request->workorder_id;
                $iouData['type'] = 2;
            } else {
                $iouData['supplier_id']  = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['boq_eme_work_order_id']  = $request->workorder_id;
                $iouData['type'] = 3;
            }
            $iouData['status'] = "Pending";
            $iouDetailData = array();
            if ($request->switch == 'employee') {
                foreach ($request->employee_purpose as  $key => $data) {
                    $iouDetailData[] = [
                        'purpose'   =>  $request->employee_purpose[$key],
                        'remarks'   =>  $request->employee_remarks[$key],
                        'amount'    =>  $request->employee_amount[$key],
                    ];
                }
            } else {
                foreach ($request->purpose as  $key => $data) {
                    $iouDetailData[] = [
                        'purpose'        =>  $request->purpose[$key],
                        'amount'         =>  $request->amount[$key],
                    ];
                }
            }
            DB::transaction(function () use ($iouData, $iouDetailData, $request) {
                $iou = Iou::create($iouData);
                $iou->ioudetails()->createMany($iouDetailData);
            });

            return redirect()->route('ious.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Iou  $iou
     * @return \Illuminate\Http\Response
     */
    public function show(Iou $iou)
    {
        return view('procurement.ious.show', compact('iou'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Iou  $iou
     * @return \Illuminate\Http\Response
     */
    public function edit(Iou $iou)
    {
        $formType = "edit";
        $materials = NestedMaterial::notInPo($iou->mpr_no)->get()->pluck('name', 'id');
        return view('procurement.ious.create', compact('iou', 'formType', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Iou  $iou
     * @return \Illuminate\Http\Response
     */
    public function update(IouRequest $request, Iou $iou)
    {
        try {
            $iouData = $request->only('cost_center_id', 'remarks', 'applied_date', 'iou_no');
            if ($request->switch == 'supplier') {
                $iouData['supplier_id'] = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['po_no'] = $request->po_no;
                $iouData['workorder_id']  = null;
                $iouData['boq_eme_work_order_id'] = null;
                $iouData['type'] = 1;
                $iouData['requisition_id'] = null;
            } elseif ($request->switch == 'employee') {
                $iouData['total_amount'] = $request->employee_total_amount;
                $iouData['type'] = 0;
                $iouData['po_no'] = null;
                $iouData['workorder_id'] = null;
                $iouData['supplier_id'] = null;
                $iouData['boq_eme_work_order_id'] = null;
                $iouData['requisition_id'] = $request->mpr_id;
            } elseif ($request->switch == 'construction') {
                $iouData['supplier_id'] = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['workorder_id'] = $request->workorder_id;
                $iouData['type'] = 2;
                $iouData['po_no'] = null;
                $iouData['boq_eme_work_order_id'] = null;
                $iouData['requisition_id'] = null;
            } else {
                $iouData['supplier_id']  = $request->supplier_id;
                $iouData['total_amount'] = $request->total_amount;
                $iouData['boq_eme_work_order_id'] = $request->workorder_id;
                $iouData['type'] = 3;
                $iouData['po_no'] = null;
                $iouData['workorder_id'] = null;
                $iouData['requisition_id'] = null;
            }
            $iouData['status'] = "Pending";
            $iouDetailData = array();
            if ($request->switch == 'employee') {
                foreach ($request->employee_purpose as  $key => $data) {
                    $iouDetailData[] = [
                        'purpose'   =>  $request->employee_purpose[$key],
                        'remarks'   =>  $request->employee_remarks[$key],
                        'amount'    =>  $request->employee_amount[$key],
                    ];
                }
            } else {
                foreach ($request->purpose as  $key => $data) {
                    $iouDetailData[] = [
                        'purpose'        =>  $request->purpose[$key],
                        'amount'         =>  $request->amount[$key],
                    ];
                }
            }
            DB::transaction(function () use ($iou, $iouData, $iouDetailData, $request) {
                $iou->update($iouData);
                $iou->ioudetails()->delete();
                $iou->ioudetails()->createMany($iouDetailData);
            });

            return redirect()->route('ious.index')->with('message', 'Data has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Iou  $iou
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iou $iou)
    {
        try {
            $iou->delete();
            return redirect()->route('ious.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('ious.index')->withErrors($e->getMessage());
        }
    }


    public function Pdf($id)
    {
        $iou = Iou::find($id);
        return PDF::loadview('procurement.ious.ioureportpdf', compact('iou'))->stream('iou' . $iou->iou_no . 'pdf');
    }

    public function Approve(Iou $iou, $status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($iou) {
                $q->where([['name', 'IOU'], ['department_id', $iou->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($iou) {
                $q->where('approvable_id', $iou->id)
                    ->where('approvable_type', Iou::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];



            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($iou) {
                $q->where([['name', 'IOU'], ['department_id', $iou->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($iou) {
                $q->where('approvable_id', $iou->id)
                    ->where('approvable_type', Iou::class);
            })->orderBy('order_by', 'desc')->first();
            $paymentsMode = ['A/C Payee' => 'A/C Payee', 'Cheque' => 'Cheque', 'Cash' => 'Cash', 'Pay Order' => 'Pay Order', 'Draft' => 'Draft'];
            $role = auth()->user()->roles->first();

            $approvalData = $iou->approval()->create($data);
            // dd($approvalData);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                //iou generating start
                return view('procurement.ious.iouapprovals', compact('iou', 'paymentsMode'));
            }

            // if ($role->name == 'Accounts-Manager' && $status==1){

            // }else{
            //     DB::transaction(function() use ($iou, $data, $check_approval){

            //    });
            // }
           
            return redirect()->route('ious.index')->with('message', "Iou $iou->id approved.");
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     *  Formats the date into y-m.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr(date_format(date_create($date), "m-y"), 0);
    }
}
