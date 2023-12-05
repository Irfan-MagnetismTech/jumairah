<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Project;
use App\Transaction;
use App\Procurement\Iou;
use App\Accounts\Account;
use Illuminate\Http\Request;
use App\Billing\WorkorderRate;
use App\Billing\ConstructionBill;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreConstructionBillRequest;

class BoqEmeConstructionBillController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:boq-eme-construction-bill-view|boq-eme-construction-bill-create|boq-eme-construction-bill-edit|boq-eme-construction-bill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-construction-bill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-construction-bill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-construction-bill-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constructionBills = ConstructionBill::with('project', 'supplier')->where('type', 1)->latest()->get();
        return view('eme.eme-bills.index', compact('constructionBills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('eme.eme-bills.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConstructionBillRequest $request)
    {
        try {
            DB::beginTransaction();
            $constructionBillData = $request->only('account_id', 'bill_received_date', 'title', 'work_type', 'project_id', 'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'percentage', 'remarks', 'year', 'month', 'week', 'adjusted_amount', 'cost_center_id', 'type');
            $constructionBillData['prepared_by'] = auth()->id();
            $constructionBillData['is_saved'] = 1;

            $constructionBillData['boq_eme_work_order_id'] = $request->workorder_id;
            $allPreviousConstructionBillTotal = ConstructionBill::query()
                ->where('project_id', $request->project_id)
                ->where('supplier_id', $request->supplier_id)
                ->where('boq_eme_work_order_id', $request->workorder_id)
                ->where('id', '<=', ConstructionBill::get()->last()->id ?? 0)
                ->get()
                ->map(function ($items) {
                    $items['paidBill'] = $items->transaction->paidBills()->sum('amount');
                    if ($items->paidBill == 0) {
                        $net = $items->bill_amount - ($items->bill_amount * $items->percentage / 100) - $items->adjusted_amount - $items->due_payable;
                    } else {
                        $net = $items->bill_amount - ($items->bill_amount * $items->percentage / 100) - $items->adjusted_amount - $items->paidBill;
                    }
                    return ['sum' => $net];
                })->sum('sum');
            $advance = Transaction::query()
                ->where('transactionable_type', Iou::class)
                ->whereHasMorph('transactionable', [Iou::class], function ($query) {
                    $query->where('type', 3);
                })
                ->whereHas('ledgerEntries', function ($q) use ($request) {
                    $q->where('account_id', $request->account_id);
                })
                ->get()
                ->pluck('ledgerEntries')
                ->first()
                ?->whereNull('cr_amount')
                ?->where('created_at', '<=', now())
                ?->sum('dr_amount') ?? 0;



            $due_payable = $allPreviousConstructionBillTotal - $advance + $request->bill_amount - ($request->bill_amount * $request->percentage / 100) - $request->adjusted_amount;
            $constructionBillData['due_payable'] = $due_payable;
            ConstructionBill::create($constructionBillData);
            DB::commit();
            return redirect()->route('eme.bills.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ConstructionBill $bill)
    {
        $constructionBill = $bill;
        $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $All_dates = [];

        $allConstructionBill = ConstructionBill::query()
            ->where('project_id', $constructionBill->project_id)
            ->where('supplier_id', $constructionBill->supplier_id)
            ->where('boq_eme_work_order_id', $constructionBill->boq_eme_work_order_id)
            ->where('id', '<=', $constructionBill->id)
            ->get()
            ->map(function ($items) {
                $items['paidBill'] = $items->transaction->paidBills()->sum('amount');
                return $items;
            })->groupBy(function ($item) use (&$All_dates) {
                array_push($All_dates, $item->created_at->format('Y-m-d'));
                return $item->created_at->format('Y-m-d');
            });
        $advance = Transaction::query()
            ->where('transactionable_type', Iou::class)
            ->whereHasMorph('transactionable', [Iou::class], function ($query) {
                $query->where('type', 3);
            })
            ->whereHas('ledgerEntries', function ($q) use ($constructionBill) {
                $q->where('account_id', $constructionBill->supplier->account->id);
            })
            ->get()
            ->pluck('ledgerEntries')
            ->first()
            ?->whereNull('cr_amount')
            ->where('created_at', '<=', $constructionBill->created_at)
            ->groupBy(function ($item) use (&$All_dates) {
                array_push($All_dates, $item->created_at->format('Y-m-d'));
                return $item->created_at->format('Y-m-d');
            });


        $All_dates = array_unique($All_dates);
        return view('eme.eme-bills.show', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ConstructionBill $bill)
    {
        $constructionBill = $bill;
        $WorkorderRate = [];
        $accounts = Account::where('balance_and_income_line_id', 14)->where('parent_account_id', 111)->pluck('account_name', 'id');
        return view('eme.eme-bills.create', compact('constructionBill', 'accounts', 'WorkorderRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConstructionBillRequest $request, ConstructionBill $bill)
    {
        try {
            $constructionBill = $bill;
            DB::beginTransaction();
            $constructionBillData = $request->only('account_id', 'bill_received_date', 'title', 'work_type', 'project_id', 'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'percentage', 'remarks', 'year', 'month', 'week', 'adjusted_amount', 'cost_center_id', 'type');

            $constructionBillData['is_saved'] = 1;

            $constructionBillData['boq_eme_work_order_id'] = $request->workorder_id;
            $constructionBillData['workorder_id'] = null;
            $constructionBillData['workorder_rate_id'] = null;
            $allPreviousConstructionBillTotal = ConstructionBill::query()
                ->where('project_id', $request->project_id)
                ->where('supplier_id', $request->supplier_id)
                ->where('boq_eme_work_order_id', $request->workorder_id)
                ->where('id', '<=', $constructionBill->id)
                ->get()
                ->map(function ($items) {
                    $items['paidBill'] = $items->transaction->paidBills()->sum('amount');
                    if ($items->paidBill == 0) {
                        $net = $items->bill_amount - ($items->bill_amount * $items->percentage / 100) - $items->adjusted_amount - $items->due_payable;
                    } else {
                        $net = $items->bill_amount - ($items->bill_amount * $items->percentage / 100) - $items->adjusted_amount - $items->paidBill;
                    }
                    return ['sum' => $net];
                })->sum('sum');
            $advance = Transaction::query()
                ->where('transactionable_type', Iou::class)
                ->whereHasMorph('transactionable', [Iou::class], function ($query) {
                    $query->where('type', 3);
                })
                ->whereHas('ledgerEntries', function ($q) use ($request) {
                    $q->where('account_id', $request->account_id);
                })
                ->get()
                ->pluck('ledgerEntries')
                ->first()
                ?->whereNull('cr_amount')
                ?->where('created_at', '<=', $constructionBill->created_at)
                ?->sum('dr_amount') ?? 0;

            $due_payable = $allPreviousConstructionBillTotal - $advance + $request->bill_amount - ($request->bill_amount * $request->percentage / 100) - $request->adjusted_amount;
            $constructionBillData['due_payable'] = $due_payable;
            $constructionBill->update($constructionBillData);
            DB::commit();

            return redirect()->route('eme.bills.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConstructionBill $bill)
    {
        try {
            $constructionBill = $bill;

            $constructionBill->delete();
            return redirect()->route('eme.bills.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('eme.bills.index')->withErrors($e->getMessage());
        }
    }


    public function emeBillapproval(ConstructionBill $emeBill, $status)
    {
        try {
            DB::beginTransaction();
            $constructionBill = $emeBill;
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($constructionBill) {
                $q->where([['name', 'EME BILL'], ['department_id', $constructionBill->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($constructionBill) {
                $q->where('approvable_id', $constructionBill->id)
                    ->where('approvable_type', ConstructionBill::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($constructionBill) {
                $q->where([['name', 'EME BILL'], ['department_id', $constructionBill->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($constructionBill) {
                $q->where('approvable_id', $constructionBill->id)
                    ->where('approvable_type', ConstructionBill::class);
            })->orderBy('order_by', 'desc')->first();
            $approvalData = $constructionBill->approval()->create($data);
            $data['status'] = $status;
            $constructionBill->update($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                $accounts = Account::where('balance_and_income_line_id', 14)->where('parent_account_id', 138)->pluck('account_name', 'id');
                return view('eme.eme-bills.constructionBillApprovals', compact('accounts', 'constructionBill'));
            }
            return redirect()->route('eme.bills.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function emeBillapprovalStore(Request $request)
    {
        try {

            $billData = ConstructionBill::where('id', $request->id)->first();
            $costCenter = $request->cost_center_id;
            $transection['voucher_type'] = 'Journal';
            $transection['bill_no'] = $request->bill_no;
            $transection['transaction_date'] = date('d-m-Y', strtotime(now()));
            $transection['narration'] = $request->remarks;
            $transection['user_id'] = auth()->user()->id;
            $data['status'] = 'Accepted';

            $totalBill = $request->bill_amount;
            $adjusted_amount = $billData->adjusted_amount ? $billData->adjusted_amount : 0;
            $totalBill_after_adjustment = $totalBill - $adjusted_amount;
            $percentageAmount = ($request->percentage / 100) * $totalBill;
            $sequirityMoney = $totalBill - $percentageAmount;

            $accountData['account_name'] = 'Security Deposite - ' . $request->supplier_name;
            $accountData['account_type'] = 2;
            $accountData['account_code'] = "26-33-34-";
            $accountData['balance_and_income_line_id'] = 34;

            $account = Account::where('balance_and_income_line_id', 34)->where('accountable_type', Supplier::class)
                ->where('accountable_id', $request->supplier_id)->first();

            $creditLedger['account_id'] = $account->id;
            $creditLedger['cr_amount'] = $billData->due_payable;
            $creditLedger['cost_center_id'] = $costCenter;

            $sequirityLedger['cr_amount'] = $percentageAmount;
            $sequirityLedger['cost_center_id'] = $costCenter;

            $debitLedger['account_id'] = $request->account_id;
            $debitLedger['dr_amount'] = $totalBill_after_adjustment;
            $debitLedger['cost_center_id'] = $costCenter;

            DB::transaction(function () use ($data, $billData, $sequirityLedger, $transection, $debitLedger, $creditLedger, $accountData) {
                ConstructionBill::where('id', $billData->id)->update($data);
                $sequrityAccount = Account::updateOrCreate($accountData);
                $transectionData = $billData->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);

                $sequirityLedger['account_id'] = $sequrityAccount->id;

                $transectionData->ledgerEntries()->create($creditLedger);
                $transectionData->ledgerEntries()->create($sequirityLedger);
            });
            return redirect()->route('eme.bills.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf(ConstructionBill $bills)
    {
        $constructionBill = $bills;
        $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $All_dates = [];
        if ($constructionBill->type == 0) {
            $allConstructionBill = ConstructionBill::query()
                ->where('project_id', $constructionBill->project_id)
                ->where('supplier_id', $constructionBill->supplier_id)
                ->where('workorder_id', $constructionBill->workorder_id)
                ->where('id', '<=', $constructionBill->id)
                ->get()
                ->map(function ($items) {
                    $items['paidBill'] = $items->transaction->paidBills()->sum('amount');
                    return $items;
                })->groupBy(function ($item) use (&$All_dates) {
                    array_push($All_dates, $item->created_at->format('Y-m-d'));
                    return $item->created_at->format('Y-m-d');
                });

            $advance = Transaction::query()
                ->where('transactionable_type', Iou::class)
                ->whereHasMorph('transactionable', [Iou::class], function ($query) {
                    $query->where('type', 2);
                })
                ->whereHas('ledgerEntries', function ($q) use ($constructionBill) {
                    $q->where('account_id', $constructionBill->supplier->account->id);
                })
                ->get()
                ->pluck('ledgerEntries')
                ->first()
                ?->whereNull('cr_amount')
                ->where('created_at', '<=', $constructionBill->created_at)
                ->groupBy(function ($item) use (&$All_dates) {
                    array_push($All_dates, $item->created_at->format('Y-m-d'));
                    return $item->created_at->format('Y-m-d');
                });
        } else {
            $allConstructionBill = ConstructionBill::query()
                ->where('project_id', $constructionBill->project_id)
                ->where('supplier_id', $constructionBill->supplier_id)
                ->where('boq_eme_work_order_id', $constructionBill->boq_eme_work_order_id)
                ->where('id', '<=', $constructionBill->id)
                ->get()
                ->map(function ($items) {
                    $items['paidBill'] = $items->transaction->paidBills()->sum('amount');
                    return $items;
                })->groupBy(function ($item) use (&$All_dates) {
                    array_push($All_dates, $item->created_at->format('Y-m-d'));
                    return $item->created_at->format('Y-m-d');
                });

            $advance = Transaction::query()
                ->where('transactionable_type', Iou::class)
                ->whereHasMorph('transactionable', [Iou::class], function ($query) {
                    $query->where('type', 3);
                })
                ->whereHas('ledgerEntries', function ($q) use ($constructionBill) {
                    $q->where('account_id', $constructionBill->supplier->account->id);
                })
                ->get()
                ->pluck('ledgerEntries')
                ->first()
                ?->whereNull('cr_amount')
                ->where('created_at', '<=', $constructionBill->created_at)
                ->groupBy(function ($item) use (&$All_dates) {
                    array_push($All_dates, $item->created_at->format('Y-m-d'));
                    return $item->created_at->format('Y-m-d');
                });
        }





        $All_dates = array_unique($All_dates);
        //return view('billing.construction-bills.pdf', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'));
        return \PDF::loadview('eme.eme-bills.pdf', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'))->stream('billing.workorder.pdf');
    }
}
