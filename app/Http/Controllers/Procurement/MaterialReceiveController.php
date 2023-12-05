<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;

use App\Http\Requests\MaterialReceiveRequest;
use App\Procurement\MaterialReceive;
use App\Procurement\PurchaseOrder;
use App\Procurement\PurchaseOrderDetail;
use App\Procurement\Requisitiondetails;
use App\Procurement\StockHistory;
use App\Procurement\Supplier;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialReceiveController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:materialReceiv-view|materialReceiv-create|materialReceiv-edit|materialReceiv-delete', ['only' => ['index', 'show', 'materialReceiveApproval',]]);
        $this->middleware('permission:materialReceiv-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:materialReceiv-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:materialReceiv-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $receives = MaterialReceive::latest()->get();
        return view('procurement.materialReceives.index', compact('receives'));
    }

    public function create()
    {
        $formType = "create";
        $purchase_orders = [];
        return view('procurement.materialReceives.create', compact('formType', 'purchase_orders'));
    }

    public function store(MaterialReceiveRequest $request)
    {
        try {
            if ($request->mrr_type == 'withOutIou') {
                $receiveData = $request->only('date', 'po_no', 'mrr_no', 'cost_center_id', 'date', 'quality', 'remarks');
                $receiveData['status'] = "Pending";

                $receiveDetailData = array();
                foreach ($request->material_id as $key => $data) {
                    $receiveDetailData[] = [
                        'floor_id'          =>  $request->floor_id[$key] ?? null,
                        'material_id'       =>  $request->material_id[$key],
                        'quantity'          =>  $request->quantity[$key],
                        'brand'             =>  $request->brand[$key],
                        'origin'            =>  $request->origin[$key],
                        'challan_no'        =>  $request->challan_no[$key],
                        'mrr_challan_key'   =>  $request->mrr_no . '_' . $request->challan_no[$key],
                        'ledger_folio_no'   =>  $request->ledger_folio_no[$key],
                    ];
                }
            } else {
                $receiveData = $request->only('date', 'iou_id', 'mrr_no', 'requisition_id');
                $receiveData['cost_center_id'] = $request->with_iou_cost_center_id;

                $receiveDetailData = array();
                foreach ($request->with_iou_material_id as $key => $data) {
                    $receiveDetailData[] = [
                        'material_id'       =>  $request->with_iou_material_id[$key],
                        'purpose'           =>  $request->purpose[$key],
                        'quantity'          =>  $request->with_iou_material_qty[$key],
                        'rate'              =>  $request->rate[$key],
                    ];
                }
            }
            DB::transaction(function () use ($receiveData, $request, $receiveDetailData) {
                $receive = MaterialReceive::create($receiveData);
                $receive->materialreceivedetails()->createMany($receiveDetailData);
            });

            return redirect()->route('materialReceives.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(MaterialReceive $materialReceife)
    {
        return view('procurement.materialReceives.show', compact('materialReceife'));
    }

    public function edit(MaterialReceive $materialReceife)
    {
        $formType = "edit";
        $data = [];

        $materialReceived = MaterialReceive::with('purchaseorderForPo')->findOrFail($materialReceife->id);
        $purchase_orders = PurchaseOrder::where('mpr_no', $materialReceived->purchaseorderForPo->mpr_no)
            ->get()
            ->pluck('po_no', 'po_no');

        $requisition_data = $materialReceived->purchaseorderForPo->mpr->mpr_no;

        $floors = Requisitiondetails::whereHas('requisition', function ($query) use ($requisition_data) {
            return $query->where('mpr_no', $requisition_data);
        })
            ->whereNotNull('floor_id')
            ->groupBy('floor_id')
            ->get();

        return view('procurement.materialReceives.create', compact('materialReceived', 'purchase_orders', 'formType', 'floors'));
    }

    public function update(MaterialReceiveRequest $request, MaterialReceive $materialReceife)
    {
        try {
            if ($request->mrr_type == 'withOutIou') {
                $receiveData = $request->only('date', 'po_no', 'mrr_no', 'cost_center_id', 'date', 'quality', 'remarks');
                $receiveData['iou_id'] = null;
                $receiveData['requisition_id'] = null;

                $receiveDetailData = array();
                foreach ($request->material_id as $key => $data) {
                    $receiveDetailData[] = [
                        'floor_id'          =>  $request->floor_id[$key] ?? null,
                        'material_id'       =>  $request->material_id[$key],
                        'quantity'          =>  $request->quantity[$key],
                        'brand'             =>  $request->brand[$key],
                        'origin'            =>  $request->origin[$key],
                        'challan_no'        =>  $request->challan_no[$key],
                        'mrr_challan_key'   =>  $request->mrr_no . '_' . $request->challan_no[$key],
                        'ledger_folio_no'   =>  $request->ledger_folio_no[$key],
                    ];
                }
            } else {
                $receiveData = $request->only('date', 'iou_id', 'mrr_no', 'requisition_id');
                $receiveData['cost_center_id'] = $request->with_iou_cost_center_id;
                $receiveData['po_no'] = null;
                $receiveData['quality'] = null;
                $receiveData['remarks'] = null;

                $receiveDetailData = array();
                foreach ($request->with_iou_material_id as $key => $data) {
                    $receiveDetailData[] = [
                        'material_id'       =>  $request->with_iou_material_id[$key],
                        'purpose'           =>  $request->purpose[$key],
                        'quantity'          =>  $request->with_iou_material_qty[$key],
                        'rate'              =>  $request->rate[$key],
                    ];
                }
            }

            DB::transaction(function () use ($materialReceife, $receiveData, $request, $receiveDetailData) {

                $materialReceife->update($receiveData);
                $materialReceife->materialreceivedetails()->delete();
                $materialReceife->materialreceivedetails()->createMany($receiveDetailData);
            });

            return redirect()->route('materialReceives.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    public function destroy(MaterialReceive $materialReceife)
    {
        try {
            $materialReceife->delete();
            return redirect()->route('materialReceives.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('materialReceives.index')->withErrors($e->getMessage());
        }
    }

    public function materialReceiveApproval(MaterialReceive $materialReceive, $status)
    {
        // dd($materialReceive->date);
        try {
            $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($materialReceive) {
                $q->where([['name', 'Material Receive Report'], ['department_id', $materialReceive->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($materialReceive) {
                $q->where('approvable_id', $materialReceive->id)->where('approvable_type', MaterialReceive::class);
            })->orderBy('order_by', 'asc')->first();

            $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($materialReceive) {
                $q->where([['name', 'Material Receive Report'], ['department_id', $materialReceive->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($materialReceive) {
                $q->where('approvable_id', $materialReceive->id)->where('approvable_type', MaterialReceive::class);
            })->orderBy('order_by', 'desc')->first();

            $data = [
                'layer_key' => $approvalfirst->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            DB::transaction(function () use ($materialReceive, $approvallast, $data) {
                $approvalData  = $materialReceive->approval()->create($data);
                if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
                    // stock claculation start
                    if ($materialReceive->iou_id) {
                        $material_ids =  $materialReceive->materialreceivedetails->pluck('material_id');
                        $stock_history_data = StockHistory::query()->where('cost_center_id', $materialReceive->cost_center_id)
                            ->whereIn('material_id', $material_ids)->get()
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->material_id => $item
                                ];
                            });

                        $GetPreviousData = StockHistory::query()->where('cost_center_id', $materialReceive->cost_center_id)
                            ->where('material_receive_report_id', $materialReceive->id)
                            ->whereIn('material_id', $material_ids)->get()
                            ->groupBy('material_id')
                            ->mapWithKeys(function ($items, $key) use ($data) {
                                $total = 0;
                                foreach ($items as $item) {
                                    $total += $item->after_discount_po * $item->quantity;
                                }
                                return [
                                    $items[0]->material_id => [
                                        'total_after_discount_po' => $items->flatten()->sum('after_discount_po'),
                                        'total_quantity' => $items->flatten()->sum('quantity'),
                                        'total' => $total
                                    ]
                                ];
                            });
                        $materialGroups  = $materialReceive->materialreceivedetails->groupBy('material_id');
                        foreach ($materialGroups as $key => $materialGroup) {
                            $Quantity = $materialGroup->flatten()->sum('quantity') ?? 0;
                            $Amount = $materialGroup->flatten()->sum('quantity') * $materialGroup->flatten()->sum('rate');
                            $rate = $materialGroup->flatten()->sum('rate');
                            $present_stock = $Quantity + ($stock_history_data[$key]->present_stock ?? 0);
                            $total_amount = ($GetPreviousData[$key]['total'] ?? 0) + $Amount;
                            $total_quantity = ($GetPreviousData[$key]['total_quantity'] ?? 0) + $Quantity;
                            $average = $total_amount / $total_quantity;

                            $stock_data[] = [
                                'cost_center_id'    =>  $materialReceive->cost_center_id,
                                'material_id'       =>  $key,
                                'previous_stock'    =>  $stock_history_data[$key]->present_stock ?? 0,
                                'quantity'          =>  $Quantity,
                                'date'              =>  date('Y-m-d', strtotime($materialReceive->date)),
                                'present_stock'     =>  $present_stock,
                                'average_cost'      =>  $average,
                                'after_discount_po' =>  $rate
                            ];
                        }
                    } else {
                        $material_ids =  $materialReceive->materialreceivedetails->pluck('material_id');
                        $stock_history_data = StockHistory::where('cost_center_id', $materialReceive->cost_center_id)
                            ->whereIn('material_id', $material_ids)->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->material_id => $item];
                            });

                        $purchase_order = PurchaseOrder::where('po_no', $materialReceive->po_no)->first();

                        $purchase_order_details = PurchaseOrderDetail::where('purchase_order_id', $purchase_order->id)
                            ->whereIn('material_id', $material_ids)->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->material_id => $item];
                            });
                        $materialGroups  = $materialReceive->materialreceivedetails->groupBy('material_id');
                        $stock_data = array();
                        foreach ($materialGroups as $key => $materialGroup) {
                            $totalQuantity = 0;
                            foreach ($materialGroup as $quantity_data) {
                                $totalQuantity += $quantity_data->quantity;
                            }
                            if (!empty($stock_history_data[$key])) {
                                $present_stock                              =   $totalQuantity + $stock_history_data[$key]->present_stock;
                                $total_previous_unit_cost   = $stock_history_data[$key]->average_cost * $stock_history_data[$key]->present_stock;

                                // per unit cost after discount start
                                $total_discount            =   $purchase_order->discount;
                                $sub_total                 =   $purchase_order->final_total + $purchase_order->discount - $purchase_order->carrying_charge - $purchase_order->labour_charge;
                                $discounted_value          =   $total_discount / $sub_total;
                                $po_details_total_price    =   $purchase_order_details[$key]->total_price;
                                $discounted_price_for_total_qty = $discounted_value * $po_details_total_price;
                                $total_amount_after_discount = $po_details_total_price - $discounted_price_for_total_qty;
                                $per_unit_price_after_discount = $total_amount_after_discount / $purchase_order_details[$key]->quantity;
                                // per unit cost after discount end

                                $total_present_unit_cost    = $totalQuantity * $per_unit_price_after_discount;
                                $total_cost                 = $total_previous_unit_cost + $total_present_unit_cost;
                                $per_material_average_cost_after_discount    = $total_cost /  $present_stock;

                                $stock_data[] = [
                                    'cost_center_id'    =>  $materialReceive->cost_center_id,
                                    'material_id'       =>  $key,
                                    'previous_stock'    =>  $stock_history_data[$key]->present_stock,
                                    'date'              =>  date('Y-m-d', strtotime($materialReceive->date)),
                                    'quantity'          =>  $totalQuantity,
                                    'present_stock'     =>  $present_stock,
                                    'average_cost'      =>  $per_material_average_cost_after_discount,
                                    'after_discount_po'      =>  $per_unit_price_after_discount
                                ];
                            } else {
                                $material_ids =  $materialReceive->materialreceivedetails->pluck('material_id');
                                $purchase_order = PurchaseOrder::where('po_no', $materialReceive->po_no)->first();
                                $purchase_order_details = PurchaseOrderDetail::where('purchase_order_id', $purchase_order->id)
                                    ->whereIn('material_id', $material_ids)
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                        return [
                                            $item->material_id => $item
                                        ];
                                    });
                                $total_discount            =   $purchase_order->discount; //500
                                $sub_total                 =   $purchase_order->final_total + $purchase_order->discount - $purchase_order->carrying_charge - $purchase_order->labour_charge;
                                $discounted_value          =   $total_discount / $sub_total;
                                $po_details_total_price    =   $purchase_order_details[$key]->total_price; //40000
                                $discounted_price_for_total_qty = $discounted_value * $po_details_total_price; //126.98
                                $total_amount_after_discount = $po_details_total_price - $discounted_price_for_total_qty; //39873.02
                                $per_unit_price_after_discount = $total_amount_after_discount / $purchase_order_details[$key]->quantity; //50

                                $stock_data[] = [
                                    'cost_center_id'    =>  $materialReceive->cost_center_id,
                                    'material_id'       =>  $key,
                                    'date'              =>  date('Y-m-d', strtotime($materialReceive->date)),
                                    'previous_stock'    =>  0,
                                    'quantity'          =>  $totalQuantity,
                                    'present_stock'     =>  $totalQuantity,
                                    'average_cost'      =>  $per_unit_price_after_discount,
                                    'after_discount_po'      =>  $per_unit_price_after_discount
                                ];
                            }
                        }
                    }
                    $materialReceive->stockHistory()->createMany($stock_data);
                    //stock claculation end

                    // accounts start

                    $transection['voucher_type'] = 'Journal';
                    $transection['transaction_date'] = $materialReceive->date;
                    $transection['user_id'] = auth()->user()->id;
                    $challanwiseMaterials = $materialReceive->materialreceivedetails->groupBy(['mrr_challan_key', 'nestedMaterials.account_id']);
                    $transectionData = $materialReceive->transaction()->create($transection);
                    $totalAmount = 0;
                    $accountData = array();
                    foreach ($challanwiseMaterials as $key => $receiveDetails) {
                        // dump($receiveDetails);
                        foreach ($receiveDetails as $keyDtl => $receiveDetail) {
                            $total = 0;
                            $materialName = [];
                            foreach ($receiveDetail as $receiveData) {
                                $stockHistory = StockHistory::where('material_id', $receiveData->material_id)
                                    ->where('material_receive_report_id', $materialReceive->id)->first();
                                $totalPrice =  $stockHistory->after_discount_po * $receiveData->quantity;
                                $total += $stockHistory->after_discount_po * $receiveData->quantity;
                                // $materialName[] = $stockHistory->nestedMaterials->name;
                            }
                            $accountData[] = [
                                'account_id' => $keyDtl,
                                'dr_amount' => $total,
                                'pourpose' => empty($materialReceive->iou_id) ? $key : null,
                                // 'remarks' => implode(',',$materialName),
                                'cost_center_id' => $materialReceive->cost_center_id,
                            ];
                            $totalAmount += $total;
                        }
                    }


                    $transectionData->ledgerEntries()->createMany($accountData);
                    if (!empty($materialReceive->iou_id)) {
                        $creditAccount = Account::where('accountable_type', User::class)->where('accountable_id', $materialReceive->iou->applied_by)->first();
                    } else {
                        $creditAccount = Account::where('accountable_type', Supplier::class)->where('accountable_id', $materialReceive->purchaseorderForPo->supplier_id)->first();
                    }
                    $supplierData['account_id'] = $creditAccount->id;
                    $supplierData['cost_center_id'] = $materialReceive->cost_center_id;
                    $supplierData['cr_amount'] = $totalAmount;

                    $transectionData->ledgerEntries()->create($supplierData);

                    $data['status'] = 'Approved';
                    $materialReceive->update($data);
                }
            });
            return redirect()->route('materialReceives.index')->with('message', "MRR $materialReceive->mrr_no has Approved  Successfully");
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
