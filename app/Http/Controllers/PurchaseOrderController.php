<?php

namespace App\Http\Controllers;

use App\Approval\ApprovalLayerDetails;
use App\CostCenter;
use App\Http\Requests\PurchaseorderRequest;
use App\Procurement\CsSupplier;
use App\Procurement\PurchaseOrder;
use App\Procurement\Requisitiondetails;
use App\Procurement\PoReportMonthWise;
use App\Procurement\PoReportProjectWise;
use App\Procurement\Requisition;
use App\Procurement\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Barryvdh\DomPDF\Facade as PDF;
use App\Services\UniqueNoGenaratorService;

class PurchaseOrderController extends Controller
{

    use HasRoles;

    private $uniqueNoGenarate;

    function __construct()
    {
        $this->middleware('permission:purchase-order-view|movement-create|purchase-order-edit|purchase-order-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:purchase-order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:purchase-order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:purchase-order-delete', ['only' => ['destroy']]);
        $this->uniqueNoGenarate = new UniqueNoGenaratorService();
    }

    public function index()
    {
        $purchaseorders = PurchaseOrder::with('material_receive')->latest()->get();

        return view('procurement.purchaseOrders.index', compact('purchaseorders',));
    }


    public function create()
    {
        $formType = "create";
        $suppliers = $materials = [];
        $units = Unit::orderBy('name')->pluck('name', 'id');

        return view('procurement.purchaseOrders.create', compact('formType', 'units', 'suppliers', 'materials'));
    }


    public function store(PurchaseorderRequest $request)
    {
        try {
            $purchaseorderData = $request->only('date', 'mpr_no', 'cs_id', 'supplier_id', 'final_total', 'carrying_charge', 'labour_charge', 'discount', 'source_tax', 'source_vat', 'carrying', 'remarks', 'receiver_contact', 'receiver_name');

            $POpurchaseOrderData['cost_center_id'] = $request['cost_center_id'];
            $purchaseorderData['po_no'] = "-";

            $purchaseorderDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $discountAllocat = ($request->total_price[$key] - (($request->discount / $request->sub_total) * $request->total_price[$key])) / $request->quantity[$key];
                $purchaseorderDetailData[] = [
                    'material_id' => $request->material_id[$key],
                    'brand' => $request->brand[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'discount_price' => $discountAllocat,
                    'total_price' => $request->total_price[$key],
                    'required_date' => $request->required_date[$key]
                ];
            }
            DB::transaction(function () use ($purchaseorderData, $purchaseorderDetailData) {

                $purchaseorder = PurchaseOrder::create($purchaseorderData);
                $purchaseorder->purchaseOrderDetails()->createMany($purchaseorderDetailData);
            });

            return redirect()->route('purchaseOrders.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            $materials = Requisitiondetails::with('material')->where('requisition_id', $request->mpr_id)->get()->pluck('material.name', 'material.id');;
            $request['materials'] = $materials;
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return view('procurement.purchaseOrders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $formType = "edit";
        $suppliers = CsSupplier::with('supplier')
            ->where('cs_id', $purchaseOrder->cs_id)
            ->get()
            ->pluck('supplier.name', 'supplier.id');
        $materials = Requisitiondetails::with('nestedMaterial')->where('requisition_id', $purchaseOrder->mpr_no)->get()->pluck('nestedMaterial.name', 'nestedMaterial.id');
        $units = [];
        return view('procurement.purchaseOrders.create', compact('purchaseOrder', 'formType', 'suppliers', 'materials', 'units'));
    }


    public function update(PurchaseorderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseorderData = $request->only('date', 'mpr_no', 'cs_id', 'supplier_id', 'final_total', 'carrying_charge', 'labour_charge', 'discount', 'source_tax', 'carrying', 'source_vat', 'remarks', 'receiver_contact', 'receiver_name');

            $purchaseorderDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $discountAllocat = ($request->total_price[$key] - (($request->discount / $request->sub_total) * $request->total_price[$key])) / $request->quantity[$key];
                $purchaseorderDetailData[] = [
                    'material_id' => $request->material_id[$key],
                    'brand' => $request->brand[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'discount_price' => $discountAllocat,
                    'total_price' => $request->total_price[$key],
                    'required_date' => $request->required_date[$key]
                ];
            }

            $date = $this->formatDate($purchaseOrder->date);

            DB::transaction(function () use ($purchaseOrder, $purchaseorderData, $purchaseorderDetailData) {
                $purchaseOrder->update($purchaseorderData);
                $purchaseOrder->purchaseOrderDetails()->delete();
                $purchaseOrder->purchaseOrderDetails()->createMany($purchaseorderDetailData);
            });
            return redirect()->route('purchaseOrders.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(\App\Procurement\PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrder->delete();
            return redirect()->route('purchaseOrders.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('purchaseOrders.index')->withErrors($e->getMessage());
        }
    }

    // public function purchaseOrderApproval($purchaseOrderId, $status)
    // {
    //     try {
    //         $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
    //         $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($purchaseOrder) {
    //             $q->where([['name', 'Purchase Order'], ['department_id', $purchaseOrder->appliedBy->department_id]]);
    //         })->whereDoesntHave('approvals', function ($q) use ($purchaseOrder) {
    //             $q->where('approvable_id', $purchaseOrder->id)->where('approvable_type', PurchaseOrder::class);
    //         })->orderBy('order_by', 'asc')->first();

    //         $data = [
    //             'layer_key' => $approval->layer_key,
    //             'user_id' => auth()->id(),
    //             'status' => $status,
    //         ];
    //         $purchaseOrder->approval()->create($data);

    //         //po generating start
    //         $to_days_date = $this->formatDate($purchaseOrder->date);
    //         $mpr_no = $purchaseOrder->mpr_no;
    //         $requisition_data = Requisition::where('id', $mpr_no)->first();
    //         $costCenter_data = CostCenter::where('id', $requisition_data->cost_center_id)->first();
    //         $costCenter_short_name = $costCenter_data->shortName;

    //         $is_exist_projectwise_po_date = PoReportProjectWise::where('cost_center_id', $requisition_data->cost_center_id)
    //             ->where('po_date', $to_days_date)
    //             ->first();

    //         if ($is_exist_projectwise_po_date) {
    //             $PoReportProjectWiseData['project_wise_po'] = $is_exist_projectwise_po_date->project_wise_po + 1;
    //             PoReportProjectWise::where('po_date', $to_days_date)
    //                 ->where('cost_center_id', $requisition_data->cost_center_id)
    //                 ->update($PoReportProjectWiseData);
    //         } else {
    //             $PoReportProjectWiseData['cost_center_id'] = $requisition_data->cost_center_id;
    //             $PoReportProjectWiseData['project_wise_po'] = 1;
    //             $PoReportProjectWiseData['po_date'] = $to_days_date;
    //             PoReportProjectWise::create($PoReportProjectWiseData);
    //         }

    //         $is_exist_monthWise_po_date = PoReportMonthWise::where('date', $to_days_date)->first();

    //         if ($is_exist_monthWise_po_date) {
    //             $poReportMonthwiseData['month_wise_po'] = $is_exist_monthWise_po_date->month_wise_po + 1;
    //             PoReportMonthWise::where('date', $to_days_date)
    //                 ->update($poReportMonthwiseData);

    //             $po_no['po_no'] = "PO-" . $to_days_date . "-" . $costCenter_short_name . $PoReportProjectWiseData['project_wise_po'] . "-PO-" . $poReportMonthwiseData['month_wise_po'];
    //             $purchaseOrder->update($po_no);
    //         } else {
    //             $poReportMonthwiseData['date'] = $to_days_date;
    //             $poReportMonthwiseData['month_wise_po'] = 1;
    //             PoReportMonthWise::create($poReportMonthwiseData);

    //             $po_no['po_no'] = "PO-" . $to_days_date . "-" . $costCenter_short_name . $PoReportProjectWiseData['project_wise_po'] . "-PO-" . $poReportMonthwiseData['month_wise_po'];
    //             $purchaseOrder->update($po_no);
    //         }
    //         //po generating end0
    //         return redirect()->route('purchaseOrders.index')->with('message', "Purchase Orders - $purchaseOrder->po_no approved.");
    //     } catch (QueryException $e) {
    //         return redirect()->back()->withInput()->withErrors($e->getMessage());
    //     }
    // }

    public function purchaseOrderApproval(PurchaseOrder $purchaseOrder, $status)
    {
        try {
            DB::beginTransaction();
            $purchaseOrder = PurchaseOrder::find($purchaseOrder->id);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($purchaseOrder) {
                $q->where([['name', 'Purchase Order'], ['department_id', $purchaseOrder->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($purchaseOrder) {
                $q->where('approvable_id', $purchaseOrder->id)
                    ->where('approvable_type', PurchaseOrder::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($purchaseOrder) {
                $q->where([['name', 'Purchase Order'], ['department_id', $purchaseOrder->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($purchaseOrder) {
                $q->where('approvable_id', $purchaseOrder->id)
                    ->where('approvable_type', PurchaseOrder::class);
            })->orderBy('order_by', 'desc')->first();

            $approvalData = $purchaseOrder->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                //po generating start
                        $to_days_date = $this->formatDate($purchaseOrder->date);
                        $mpr_no = $purchaseOrder->mpr_no;
                        $requisition_data = Requisition::where('id', $mpr_no)->first();
                        $costCenter_data = CostCenter::where('id', $requisition_data->cost_center_id)->first();
                        $costCenter_short_name = $costCenter_data->shortName;

                        $is_exist_projectwise_po_date = PoReportProjectWise::where('cost_center_id', $requisition_data->cost_center_id)
                            ->where('po_date', $to_days_date)
                            ->first();

                        if ($is_exist_projectwise_po_date) {
                            $PoReportProjectWiseData['project_wise_po'] = $is_exist_projectwise_po_date->project_wise_po + 1;
                            PoReportProjectWise::where('po_date', $to_days_date)
                                ->where('cost_center_id', $requisition_data->cost_center_id)
                                ->update($PoReportProjectWiseData);
                        } else {
                            $PoReportProjectWiseData['cost_center_id'] = $requisition_data->cost_center_id;
                            $PoReportProjectWiseData['project_wise_po'] = 1;
                            $PoReportProjectWiseData['po_date'] = $to_days_date;
                            PoReportProjectWise::create($PoReportProjectWiseData);
                        }

                        $is_exist_monthWise_po_date = PoReportMonthWise::where('date', $to_days_date)->first();

                        if ($is_exist_monthWise_po_date) {
                            $poReportMonthwiseData['month_wise_po'] = $is_exist_monthWise_po_date->month_wise_po + 1;
                            PoReportMonthWise::where('date', $to_days_date)
                                ->update($poReportMonthwiseData);

                            // $po_no['po_no'] = $this->uniqueNoGenarate->generateUniqueNo(PurchaseOrder::class, 'PO', 'cost_center_id', $requisition_data->cost_center_id, 'po_no');
                            // $po_no['po_no'] = "PO-" . $to_days_date . "-" . $costCenter_short_name . $PoReportProjectWiseData['project_wise_po'] . "-PO-" . $poReportMonthwiseData['month_wise_po'];
                            // $purchaseOrder->update($po_no);
                        } else {
                            $poReportMonthwiseData['date'] = $to_days_date;
                            $poReportMonthwiseData['month_wise_po'] = 1;
                            PoReportMonthWise::create($poReportMonthwiseData);

                            // $po_no['po_no'] = "PO-" . $to_days_date . "-" . $costCenter_short_name . $PoReportProjectWiseData['project_wise_po'] . "-PO-" . $poReportMonthwiseData['month_wise_po'];
                            // $po_no['po_no'] = $this->uniqueNoGenarate->generateUniqueNo(PurchaseOrder::class, 'PO', 'cost_center_id', $requisition_data->cost_center_id, 'po_no');
                            // $purchaseOrder->update($po_no);
                        }
                        //po generating end0
                return redirect()->route('purchaseOrders.index')->with('message', "$purchaseOrder->id approved.");
            }
            return redirect()->route('purchaseOrders.index')->with('message', "$purchaseOrder->id approved.");
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function purchaseorderpdf($id, $type)
    {
        $purchaseOrder = PurchaseOrder::with(['mpr.project', 'cs', 'cssupplier.supplier', 'purchaseOrderDetails'])->findOrFail($id);

        if ($type == 'accounts-copy') {
            return PDF::loadview('procurement.purchaseOrders.pdf.accounts-pdf', compact('purchaseOrder'))->stream('Purchase-Order-Accounts-Copy.pdf');
        } else if ($type == 'projects-copy') {
            return PDF::loadview('procurement.purchaseOrders.pdf.projects-pdf', compact('purchaseOrder'))->stream('Purchase-Order-Accounts-Copy.pdf');
        } else if ($type == 'suppliers-copy') {
            return PDF::loadview('procurement.purchaseOrders.pdf.suppliers-pdf', compact('purchaseOrder'))->stream('Purchase-Order-Accounts-Copy.pdf');
        } else {
            abort(404);
        }
    }

    /**
     *  Formats the date into y-m.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr(date_format(date_create($date), "y-m"), 0);
    }
}
