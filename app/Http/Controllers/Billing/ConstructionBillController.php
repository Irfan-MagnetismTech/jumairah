<?php

namespace App\Http\Controllers\Billing;

use App\Transaction;
use App\Procurement\Iou;
use App\Accounts\Account;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Accounts\BankAccount;
use App\Approval\Approval;
use App\Procurement\Supplier;
use App\Billing\WorkorderRate;
use App\Billing\ConstructionBill;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use App\Billing\BillingTitle;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Http\Requests\StoreConstructionBillRequest;

class ConstructionBillController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:construction-bill-view|construction-bill-create|construction-bill-edit|construction-bill-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:construction-bill-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:construction-bill-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:construction-bill-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $constructionBills = ConstructionBill::with('project', 'supplier')->where('type', 0)->latest()->get();
        return view('billing.construction-bills.index', compact('constructionBills'));
    }

    public function eme_bill_index()
    {
    }

    public function create()
    {
        $titles = BillingTitle::all();
        $accounts = Account::where('balance_and_income_line_id', 14)->where('parent_account_id', 111)->pluck('account_name', 'id');
        return view('billing.construction-bills.create', compact('accounts', 'titles'));
    }

    public function eme_bill_create()
    {
        $accounts = Account::where('balance_and_income_line_id', 14)->where('parent_account_id', 111)->pluck('account_name', 'id');
        return view('billing.construction-bills.create', compact('accounts'));
    }

    public function store(StoreConstructionBillRequest $request)
    {
        try {
            DB::beginTransaction();
            $constructionBillData = $request->only('account_id', 'bill_received_date', 'title', 'work_type', 'project_id', 'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'percentage', 'remarks', 'year', 'month', 'week', 'adjusted_amount', 'cost_center_id', 'type');
            $constructionBillData['prepared_by'] = auth()->id();
            $constructionBillData['is_saved'] = 1;
            if ($request->type == 0) {
                $constructionBillData['workorder_id'] = $request->workorder_id;
                $constructionBillData['workorder_rate_id'] = $request->workorder_rate_id;
                $allPreviousConstructionBillTotal = ConstructionBill::query()
                    ->where('project_id', $request->project_id)
                    ->where('supplier_id', $request->supplier_id)
                    ->where('workorder_id', $request->workorder_id)
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
                        $query->where('type', 2);
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
                $lineData = [];
                foreach ($request->billing_title_id as $key => $value) {
                    $lineData[] = [
                        'billing_title_id' => $request->billing_title_id[$key],
                        'amount' => $request->amount[$key],
                    ];
                }
            } else {
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
            }


            $due_payable = $allPreviousConstructionBillTotal - $advance + $request->bill_amount - ($request->bill_amount * $request->percentage / 100) - $request->adjusted_amount;
            $constructionBillData['due_payable'] = $due_payable;
            $constructionData = ConstructionBill::create($constructionBillData);
            $constructionData->lines()->createMany($lineData);
            DB::commit();
            if ($request->type == 0) {
                return redirect()->route('construction-bills.index')->with('message', 'Data has been inserted successfully');
            } else {
                return redirect()->route('eme.eme-bills.index')->with('message', 'Data has been inserted successfully');
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(ConstructionBill $constructionBill)
    {
        $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $All_dates = [];
        // $allConstructionBill = ConstructionBill::query()
        //                 ->where('project_id',$constructionBill->project_id)
        //                 ->where('supplier_id',$constructionBill->supplier_id)
        //                 ->where('workorder_id',$constructionBill->workorder_id)
        //                 ->where('id','<=',$constructionBill->id)
        //                 ->get()
        //                 ->map(function($items){
        //                     $items['paidBill'] =$items->transaction->paidBills()->sum('amount');
        //                     return $items;
        //                 })->groupBy(function($item)use(&$All_dates){
        //                     array_push($All_dates, $item->created_at->format('Y-m-d'));
        //                     return $item->created_at->format('Y-m-d');
        //                     });

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
        if ($constructionBill->type == 0) {
            return view('billing.construction-bills.show', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'));
        } else {
            return view('eme.eme-bills.show', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'));
        }
    }

    public function edit(ConstructionBill $constructionBill)
    {
        if ($constructionBill->type == 0) {
            $WorkorderRate = WorkorderRate::where('workorder_id', $constructionBill->workorder_id)
                ->pluck('work_level', 'id');
        } else {
            $WorkorderRate = [];
        }
        $titles = BillingTitle::all();
        $accounts = Account::where('balance_and_income_line_id', 14)->where('parent_account_id', 111)->pluck('account_name', 'id');
        return view('billing.construction-bills.create', compact('constructionBill', 'accounts', 'WorkorderRate', 'titles'));
    }

    public function update(StoreConstructionBillRequest $request, ConstructionBill $constructionBill)
    {
        try {
            DB::beginTransaction();
            $constructionBillData = $request->only('account_id', 'bill_received_date', 'title', 'work_type', 'project_id', 'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'percentage', 'remarks', 'year', 'month', 'week', 'adjusted_amount', 'cost_center_id', 'type');

            $constructionBillData['is_saved'] = 1;
            if ($request->type == 0) {
                $constructionBillData['workorder_id'] = $request->workorder_id;
                $constructionBillData['workorder_rate_id'] = $request->workorder_rate_id;
                $constructionBillData['boq_eme_work_order_id'] = null;
                $allPreviousConstructionBillTotal = ConstructionBill::query()
                    ->where('project_id', $request->project_id)
                    ->where('supplier_id', $request->supplier_id)
                    ->where('workorder_id', $request->workorder_id)
                    ->where('id', '<', $constructionBill->id)
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
                        $query->where('type', 2);
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
                $lineData = [];
                if(!empty($request->billing_title_id)){
                    foreach ($request->billing_title_id as $key => $value) {
                        $lineData[] = [
                            'billing_title_id' => $request->billing_title_id[$key],
                            'amount' => $request->amount[$key],
                        ];
                    }
                }
            } else {
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
            }
            // $advance = Transaction::query()
            //             ->where('transactionable_type', Iou::class)
            //             ->whereHas('ledgerEntries', function($q) use($request){
            //                 $q->where('account_id', $request->account_id);
            //             })
            //             ->get()
            //             ->pluck('ledgerEntries')
            //             ->first()
            //             ?->whereNull('cr_amount')
            //             ?->where('created_at','<=',$constructionBill->created_at)
            //             ?->sum('dr_amount') ?? 0;

            $due_payable = $allPreviousConstructionBillTotal - $advance + $request->bill_amount - ($request->bill_amount * $request->percentage / 100) - $request->adjusted_amount;
            $constructionBillData['due_payable'] = $due_payable;
            $constructionBill->update($constructionBillData);
            $constructionBill->lines()->delete();
            $constructionBill->lines()->createMany($lineData);
            DB::commit();
            if ($request->type == 0) {
                return redirect()->route('construction-bills.index')->with('message', 'Data has been updated successfully');
            } else {
                return redirect()->route('eme.eme-bills.index')->with('message', 'Data has been updated successfully');
            }
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(ConstructionBill $constructionBill)
    {
        try {
            if ($constructionBill->type == 0) {
                $constructionBill->delete();
                return redirect()->route('construction-bills.index')->with('message', 'Data has been deleted successfully');
            } else {
                $constructionBill->delete();
                return redirect()->route('eme.bills.index')->with('message', 'Data has been deleted successfully');
            }
        } catch (QueryException $e) {
            return redirect()->route('construction-bills.index')->withErrors($e->getMessage());
        }
    }

    public function pdf(ConstructionBill $constructionBill)
    {
        $spell = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $All_dates = [];
        $title_id = [];
        $title_name = [];
        if ($constructionBill->type == 0) {
            $allConstructionBill = ConstructionBill::query()
                ->where('project_id', $constructionBill->project_id)
                ->where('supplier_id', $constructionBill->supplier_id)
                ->where('workorder_id', $constructionBill->workorder_id)
                ->where('id', '<=', $constructionBill->id)
                ->get()
                ->map(function ($items) use ( &$title_id,&$title_name){
                    $items->lines->map(function ($item) use ( &$title_id,&$title_name) {
                        if (!in_array($item->billing_title_id, $title_id)) {
                            array_push($title_id, $item->billing_title_id);
                            array_push($title_name, $item->billingTitle->name);
                        }
                    });
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
                ->map(function ($items) use ( &$title_id,&$title_name){
                    $items->lines->map(function ($item) use ( &$title_id,&$title_name) {
                        if (!in_array($item->billing_title_id, $title_id)) {
                            array_push($title_id, $item->billing_title_id);
                            array_push($title_name, $item->billingTitle->name);
                        }
                    });
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

        $constructionBill->load('appliedBy.employee');
        $approvals = Approval::query()->with(['user.employee', 'approvalLayerDetails'])->where('approvable_id', $constructionBill->id)->where('approvable_type', ConstructionBill::class)->get();

        $All_dates = array_unique($All_dates);
        //return view('billing.construction-bills.pdf', compact('constructionBill', 'allConstructionBill', 'advance', 'All_dates'));
        return \PDF::loadview('billing.construction-bills.pdf', compact('title_name','title_id','constructionBill', 'allConstructionBill', 'advance', 'All_dates','approvals'))->stream('billing.workorder.pdf');
    }

    public function constructionBillapproval(ConstructionBill $constructionBill, $status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($constructionBill) {
                $q->where([['name', 'CONSTRUCTION BILL'], ['department_id', $constructionBill->appliedBy->department_id]]);
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
                $q->where([['name', 'CONSTRUCTION BILL'], ['department_id', $constructionBill->appliedBy->department_id]]);
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
                return view('billing.construction-bills.constructionBillApprovals', compact('accounts', 'constructionBill'));
            }
            return redirect()->route('construction-bills.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function constructionBillapprovalStore(Request $request)
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
            return redirect()->route('construction-bills.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }



    public function DraftSave(Request $request)
    {
        try {
            $constructionBillData = $request->only('account_id', 'bill_received_date', 'title', 'work_type', 'project_id', 'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'percentage', 'remarks', 'year', 'month', 'week', 'adjusted_amount', 'cost_center_id', 'workorder_id', 'workorder_rate_id');
            $constructionBillData['prepared_by'] = auth()->id();
            $constructionBillData['user_id'] = auth()->user()->id;
            $lineData = [];
            if(!empty($request->billing_title_id) && count($request->billing_title_id)){
                foreach ($request->billing_title_id as $key => $value) {
                    $lineData[] = [
                        'billing_title_id' => $request->billing_title_id[$key],
                        'amount' => $request->amount[$key],
                    ];
                }
            }
            if (isset($request->draft_id) && $request->draft_id != null) {
                $constructionBill = ConstructionBill::findOrFail($request->draft_id);
                DB::transaction(function () use ($constructionBillData, $constructionBill,$lineData) {
                    $constructionBill->update($constructionBillData);
                    $constructionBill->lines()->delete();
                    $constructionBill->lines()->createMany($lineData);
                });
            } else {
                DB::transaction(function () use ($constructionBillData,$lineData) {
                    $constructionData = ConstructionBill::create($constructionBillData);
                    $constructionData->lines()->createMany($lineData);
                });
            }
            return redirect()->route('construction-bills.index')->with('message', 'Draft has been saved successfully.');
        } catch (QueryException $err) {
            return redirect()->route('construction-bills.index')->withErrors($err->getMessage());
        }
    }
}
