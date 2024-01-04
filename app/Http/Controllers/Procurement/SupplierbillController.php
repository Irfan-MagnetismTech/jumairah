<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;

use App\Http\Requests\SupplierbillRequest;
use App\Procurement\Iou;
use App\Procurement\MaterialReceive;
use App\Procurement\NestedMaterial;
use App\Procurement\PurchaseOrder;
use App\Procurement\PurchaseOrderDetail;
use App\Procurement\Supplier;
use App\Procurement\Supplierbill;
use App\Procurement\Supplierbillofficebilldetails;
use App\Sells\SaleCancellation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierbillController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:supplierbill-view|supplierbill-create|supplierbill-edit|supplierbill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:supplierbill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:supplierbill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supplierbill-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $supplierbills = Supplierbill::with('officebilldetails')->latest()->get();
        return view('procurement.supplierbills.index', compact('supplierbills'));
    }


    public function create()
    {
        $formType = "create";
        return view('procurement.supplierbills.create', compact('formType'));
    }


    public function store(SupplierbillRequest $request)
    {
        try {
            $supplierbillData = $request->only('date', 'register_serial_no', 'bill_no', 'purpose', 'cost_center_id', 'carrying_charge', 'labour_charge', 'discount', 'final_total','supplier_id');
            $supplierbillData['applied_by'] = auth()->id();
            $supplierbillData['status'] = "Pending";
            $supplierbillDataDetails = array();

            DB::transaction(function () use ($supplierbillData, $supplierbillDataDetails, $request) {
                $supplierbill = Supplierbill::create($supplierbillData);

                foreach ($request->mrr_no as  $key => $data) {
                    $supplierbillDataDetails[] = [
                        'mrr_no' => $request->mrr_no[$key],
                        'po_no' => $request->po_no[$key],
                        'mpr_no' => $request->mpr_no[$key],
                        // 'supplier_id' => $request->supplier_id[$key],
                        'amount' => $request->amount[$key],
                        'remarks' => $request->remarks[$key],
                    ];
                }
                $supplierbill->officebilldetails()->createMany($supplierbillDataDetails);
            });

            return redirect()->route('supplierbills.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {

            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(Supplierbill $supplierbill)
    {
        return view('procurement.supplierbills.show', compact('supplierbill'));
    }


    public function edit(Supplierbill $supplierbill)
    {
        $formType = "edit";
        return view('procurement.supplierbills.create', compact('supplierbill', 'formType'));
    }


    public function update(SupplierbillRequest $request, Supplierbill $supplierbill)
    {
        try {
            $supplierbillData = $request->only('date', 'register_serial_no', 'bill_no', 'purpose', 'cost_center_id', 'carrying_charge', 'labour_charge', 'discount', 'final_total','supplier_id');
            $supplierbillData['status'] = "Pending";

            $supplierbillDataDetails = array();
            foreach ($request->mrr_no as  $key => $data) {
                $supplierbillDataDetails[] = [
                    'mrr_no' => $request->mrr_no[$key],
                    'po_no' => $request->po_no[$key],
                    'mpr_no' => $request->mpr_no[$key],
                    // 'supplier_id' => $request->supplier_id[$key],
                    'amount' => $request->amount[$key],
                    'remarks' => $request->remarks[$key],
                ];
            }

            DB::transaction(function () use ($supplierbillData, $supplierbillDataDetails, $supplierbill) {
                $supplierbill->update($supplierbillData);
                $supplierbill->officebilldetails()->delete();
                $supplierbill->officebilldetails()->createMany($supplierbillDataDetails);
            });

            return redirect()->route('supplierbills.index')->with('message', 'Data has been Updated successfully');
        } catch (QueryException $e) {

            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function destroy(Supplierbill $supplierbill)
    {
        try {
            $supplierbill->delete();
            return redirect()->route('supplierbills.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('supplierbills.index')->withErrors($e->getMessage());
        }
    }

    public function Pdf($id)
    {
        $supplierbill = Supplierbill::findOrFail($id);
        return PDF::loadview('procurement.supplierbills.supplierbillreportpdf', compact('supplierbill'))->stream('Purchase-Order-Accounts-Copy.pdf');
    }
    public function supplierBillRequest(Supplierbill $supplierbill)
    {
        request()->validate([
            'date' => "required|date|date_format:d-m-Y"
        ]);
        $supplierbill->request_date = request()->date;
        $supplierbill->is_requested = 1;
        $supplierbill->update();
        return redirect()->route('supplierbills.index')->with('message', "Requested");
    }

    public function supplierBillReject(Supplierbill $supplierbill)
    {

        $supplierbill->request_date = null;
        $supplierbill->is_requested = 0;
        $supplierbill->update();
        return redirect()->route('requestedSupplierbills')->with('message', "Request Rejected");
    }

    //    public function supplierBillApproveView(Supplierbill $supplierbill, $status)
    //    {
    //        return view('procurement.supplierbills.supplierBillApprove', compact('supplierbill'));
    ////        return redirect()->route('supplierbills.supplierBillApprove')->with('message', "This Supplier Bill  $status  Successfully");
    //    }

    public function supplierBillApprove(Supplierbill $supplierbill, $status)
    {
        $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($supplierbill) {
            $q->where([['name', 'Supplier Bill'], ['department_id', $supplierbill->appliedBy->department_id]]);
        })->whereDoesntHave('approvals', function ($q) use ($supplierbill) {
            $q->where('approvable_id', $supplierbill->id)->where('approvable_type', Supplierbill::class);
        })->orderBy('order_by', 'asc')->first();

        $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($supplierbill) {
            $q->where([['name', 'Supplier Bill'], ['department_id', $supplierbill->appliedBy->department_id]]);
        })->whereDoesntHave('approvals', function ($q) use ($supplierbill) {
            $q->where('approvable_id', $supplierbill->id)->where('approvable_type', Supplierbill::class);
        })->orderBy('order_by', 'desc')->first();

        $data = [
            'layer_key' => $approvalfirst->layer_key,
            'user_id' => auth()->id(),
            'status' => $status,
        ];

        $supplierAccount = $supplierbill->officebilldetails->first()->supplier->account->id;
        $transection['voucher_type'] = 'Journal';
        $transection['transaction_date'] = $supplierbill->date;
        $transection['bill_no'] = $supplierbill->bill_no;
        $transection['user_id'] = auth()->user()->id;

        // Discount Allocation start

        $poTotalAmount = 0;
        foreach ($supplierbill->officebilldetails as $billdetails) {
            foreach ($billdetails->materialReceive->materialreceivedetails as $mrrkey => $receiveDetails) {
                $purchaseOrderDtls = PurchaseOrderDetail::where('material_id', $receiveDetails->material_id)
                    ->where('purchase_order_id', $billdetails->materialReceive->purchaseorderForPo->id)->first();
                $poAmount = $purchaseOrderDtls->unit_price * $purchaseOrderDtls->quantity;
                $poTotalAmount += $poAmount;
            }
        }
        foreach ($supplierbill->officebilldetails as $key => $billdetail) {
            $billdetail->materialReceive->transaction()->update(['bill_no' => $supplierbill->bill_no]);
            if ($supplierbill->discount > 0) {
                foreach ($billdetail->materialReceive->materialreceivedetails as $receiveDetail) {
                    $purchaseOrderDtl = PurchaseOrderDetail::where('material_id', $receiveDetail->material_id)
                        ->where('purchase_order_id', $billdetail->materialReceive->purchaseorderForPo->id)->first();
                    $poAllocateAmount = $purchaseOrderDtl->unit_price * $purchaseOrderDtl->quantity;

                    $allocateDiscount = ($supplierbill->discount / $poTotalAmount) * $poAllocateAmount;

                    $topMaterial = $receiveDetail->nestedMaterials->ancestors->first();
                    $materailAccount = $receiveDetail->nestedMaterials->ancestors->where('parent_id', $topMaterial->id)->first();
                    $accountDisData[] = [
                        'account_id' => $materailAccount->account_id,
                        'cr_amount' => $allocateDiscount,
                        'pourpose' => 'discount',
                        'cost_center_id' => $billdetail->materialReceive->cost_center_id,
                    ];
                }
            } else {
                $accountDisData = [];
            }
        }
        // Discount Allocation End

        $CCAccount = Account::where('account_name', 'like', "%Carriage Inward - WIP%")->first('id');
        //            dd($CCAccount);
        $CCData['account_id'] = $CCAccount->id;
        $CCData['cost_center_id'] = $supplierbill->costCenter->id;
        $CCData['dr_amount'] = $supplierbill->carrying_charge;

        $LcAccount = Account::where('account_name', 'like', 'Daily Labor Charge-WIP')->first('id');
        $LcData['account_id'] = $LcAccount->id;
        $LcData['cost_center_id'] = $supplierbill->costCenter->id;
        $LcData['dr_amount'] = $supplierbill->labour_charge;

        $supplierData['account_id'] = $supplierAccount;
        $supplierData['cost_center_id'] = $supplierbill->costCenter->id;
        $supplierData['cr_amount'] = $supplierbill->carrying_charge + $supplierbill->labour_charge;

        $supplierDisData['account_id'] = $supplierAccount;
        $supplierDisData['cost_center_id'] = $billdetail->materialReceive->cost_center_id;
        $supplierDisData['dr_amount'] = $supplierbill->discount;
        $supplierDisData['pourpose'] = 'discount';
        //dd($CCData, $LcData,$supplierData);
        DB::transaction(function () use ($approvallast, $supplierbill, $data, $transection, $accountDisData, $CCData, $LcData, $supplierData, $supplierDisData) {
            $approvalData  = $supplierbill->approval()->create($data);
            if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
                if ($supplierbill->labour_charge > 0 || $supplierbill->carrying_charge > 0) {
                    $transectionData = $supplierbill->transaction()->create($transection);
                }
                if ($supplierbill->carrying_charge > 0) {
                    $transectionData->ledgerEntries()->create($CCData);
                }
                if ($supplierbill->labour_charge > 0) {
                    $transectionData->ledgerEntries()->create($LcData);
                }
                if ($supplierbill->labour_charge > 0 || $supplierbill->carrying_charge > 0) {
                    $transectionData->ledgerEntries()->create($supplierData);
                }
                if ($supplierbill->discount > 0) {
                    $transectionDisData = $supplierbill->transaction()->create($transection);
                    $transectionDisData->ledgerEntries()->create($supplierDisData);
                    $transectionDisData->ledgerEntries()->createMany($accountDisData);
                }
            }
        });


        //        }
        //        $data['status'] = $status;
        //        $supplierbill->update($data);

        return redirect()->route('supplierbills.index')->with('message', "This Supplier Bill  $status  Successfully");
    }

    public function requestedSupplierbills()
    {
        $places =  Supplierbill::requestedSupplier()->with(['costCenter', 'appliedBy', 'billRegister', 'officebilldetails.supplier'])->orderBy('request_date', 'asc')->get()->groupBy("request_date")->toArray();

        $total = count($places);
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = collect(array_slice($places, $perPage * ($currentPage - 1), $perPage));
        $options = [
            "path" => asset('requestedSupplierbills')
        ];
        $paginator = new LengthAwarePaginator($currentItems, count($places), $perPage, $currentPage, $options);
        $supplierbills = $paginator->appends('filter', request('filter'));



        return view('procurement.supplierbills.requestedSupplier', compact('supplierbills', 'currentItems', 'paginator'));
    }
}
