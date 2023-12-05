<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\AccountsOpeningBalance;
use App\Accounts\Depreciation;
use App\Accounts\FixedAsset;
use App\Accounts\Loan;
use App\Accounts\LoanReceipt;
use App\DepreciationDetail;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\CostCenter;
use App\LedgerEntry;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\StandardTagFactory;
use Webmozart\Assert\Assert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomeStatementExport;
use App\Exports\DayBookExport;
use App\Exports\TrialBalanceExport;
use App\Exports\FixedAssetStatementExport;
use App\Exports\BalanceIncomeLineReportExport;
use App\Exports\ProjectWipExport;

class AisReportController extends Controller
{
    public function ledger(Request $request)
    {
        // dd($request->all());
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfYear();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfYear();

        $openingBalance = AccountsOpeningBalance::where('account_id', request()->account_id);

        $accountOpeningBalance = Account::where('id', request()->account_id)
            ->with(['ledgers' => function ($query) use ($fromDate) {
                $query->whereHas('transaction', function ($q) use ($fromDate) {
                    $q->whereDate('transaction_date', '<', $fromDate);
                });
            }])->first();

        $account = Account::where('id', request()->account_id)
            ->with(['ledgers' => function ($query) use ($fromDate, $tillDate) {
                $query->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                });
            }])->first();

        if ($request->reportType == 'pdf') {
            $pdf = PDF::loadView('accounts.reports.ledger_pdf', compact('fromDate', 'tillDate', 'request', 'account', 'openingBalance', 'accountOpeningBalance'))
                ->setPaper('a4', 'landscape');
            return $pdf->stream('ledger.pdf');
        } else {
            return view('accounts.reports.ledger', compact('fromDate', 'tillDate', 'request', 'account', 'openingBalance', 'accountOpeningBalance'));
        }
    }

    public function balanceSheet()
    {
        $year = request()->year ? request()->year : date('Y', strtotime(now()));
        Session::put('request_year', $year);
        $assets = BalanceAndIncomeLine::where('line_type', 'balance_header')->where('parent_id', 1)
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')
            ->with('descendants.accounts.currentYearLedger.transaction', function ($q) use ($year) {
                $q->whereYear('transaction_date', $year);
            })->get();

        $liabilities = BalanceAndIncomeLine::where('line_type', 'balance_header')
            ->where('parent_id', 26)->orderBy('printed_no')
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')->get();

        $directExpenses = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 74)->whereIn('id', [75, 83])
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')->get();

        $indirectExpenses = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 74)->whereIn('id', [85, 90])
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')->get();

        $directIncomes = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 48)->whereIn('id', [49, 57])
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')->get();

        $indirectIncomes = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 48)->whereIn('id', [60, 69])
            ->with('descendants.accounts.currentYearLedger', 'descendants.accounts.previousYearLedger')->get();
        if (request()->reportType == 'pdf') {
            return PDF::loadview('accounts.reports.balancesheet_pdf', compact('assets', 'liabilities', 'directIncomes', 'indirectIncomes', 'directExpenses', 'indirectExpenses'))
                ->setPaper('a4', 'landscape')
                ->stream("balance_sheet_$year.pdf");
            // return view('accounts.reports.balancesheet_pdf', compact('assets', 'liabilities', 'directIncomes', 'indirectIncomes', 'directExpenses', 'indirectExpenses'));
        } else {
            return view('accounts.reports.balancesheet', compact('assets', 'liabilities', 'directIncomes', 'indirectIncomes', 'directExpenses', 'indirectExpenses'));
        }
    }

    public function incomeStatement()
    {
        $year = request()->year ? request()->year : date('Y', strtotime(now()));
        // dd(request()->year, $year);
        Session::put('request_year', $year);
        $directExpenses = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 74)->whereIn('id', [75, 83])
            ->with('descendants.accounts.currentYearLedger')->get();

        $directExpServices = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 74)->where('id', 83)
            ->with('descendants.accounts.currentYearLedger')->get();

        $indirectExpenses = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 74)->whereIn('id', [85, 90])
            ->with('descendants.accounts.currentYearLedger')->get();

        $directIncomes = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 48)->whereIn('id', [49, 57])
            ->with('descendants.accounts.currentYearLedger')->get();

        $directIncomeServices = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 48)->where('id', 57)
            ->with('descendants.accounts.currentYearLedger')->get();

        $indirectIncomes = BalanceAndIncomeLine::where('line_type', 'income_header')->where('parent_id', 48)->whereIn('id', [60, 69])
            ->with('descendants.accounts.currentYearLedger')->get();

        if (request()->reportType == 'pdf') {
            return PDF::loadview('accounts.reports.profit-and-loss_pdf', compact('directIncomes', 'directIncomeServices', 'indirectIncomes', 'directExpenses', 'directExpServices', 'indirectExpenses'))
                ->setPaper('a4', 'landscape')
                ->stream("income_statement_$year.pdf");
        } elseif (request()->reportType == 'excel') {
            return Excel::download(new IncomeStatementExport($directIncomes, $directIncomeServices, $indirectIncomes, $directExpenses, $directExpServices, $indirectExpenses), "income_statement_$year.xlsx");
        } else {
            return view('accounts.reports.profit-and-loss', compact('directIncomes', 'directIncomeServices', 'indirectIncomes', 'directExpenses', 'directExpServices', 'indirectExpenses'));
        }

        // return view('accounts.reports.profit-and-loss', compact('directIncomes', 'directIncomeServices', 'indirectIncomes', 'directExpenses', 'directExpServices', 'indirectExpenses'));
    }

    public function trialBalance()
    {
        $fromDate = request()->fromDate ? Carbon::createFromFormat('d-m-Y', request()->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = request()->tillDate ? Carbon::createFromFormat('d-m-Y', request()->tillDate)->endOfDay() : Carbon::now()->endOfMonth();

        $balanceIncomeHeaders = BalanceAndIncomeLine::with(
            'descendants.accounts.previousYearLedger',
            'descendants.accounts.currentYearLedger'
        )
            ->whereIn('line_type', ['income_header', 'balance_header'])
            ->get();
        if (request()->reportType == 'pdf') {
            return PDF::loadview('accounts.reports.trial-balance-pdf', compact('balanceIncomeHeaders', 'fromDate', 'tillDate'))
                ->setPaper('a4', 'landscape')
                ->stream("trial_balance.pdf");
        } elseif (request()->reportType == 'excel') {
            return Excel::download(new TrialBalanceExport($fromDate, $tillDate, $balanceIncomeHeaders), "trial_balance.xlsx");
        } else {
            return view('accounts.reports.trial-balance', compact('balanceIncomeHeaders', 'fromDate', 'tillDate'));
        }
    }

    public function daybook(Request $request)
    {
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : now()->startOfDay();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : now()->endOfDay();
        $ledgetEntries = LedgerEntry::with('transaction', 'account')
            ->when($request->account_id, function ($q) {
                $q->where('account_id', request()->account_id);
            })
            ->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
            })->latest()->get();
        if ($request->reportType == 'pdf') {
            return PDF::loadview('accounts.reports.day-book-pdf', compact('ledgetEntries', 'fromDate', 'tillDate'))
                ->setPaper('a4', 'landscape')
                ->stream("daybook.pdf");
        } elseif ($request->reportType == 'excel') {
            return Excel::download(new DaybookExport($fromDate, $tillDate, $ledgetEntries), "daybook.xlsx");
        } else {
            return view('accounts.reports.day-book', compact('ledgetEntries', 'request', 'fromDate', 'tillDate'));
        }
    }

    public function costCenterBreakup(Request $request)
    {
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfMonth();

        $balanceIncomeHeaders = BalanceAndIncomeLine::wherehas('descendants.accounts.currentYearLedger', function ($q) {
            $q->where('cost_center_id', request()->project_id);
        })
            ->with([
                'descendants.accounts.currentYearLedger' => function ($q) {
                    $q->where('cost_center_id', request()->project_id);
                }
            ])
            ->with([
                'descendants.accounts.previousYearLedger' => function ($q) {
                    $q->where('cost_center_id', request()->project_id);
                }
            ])
            ->whereIn('line_type', ['income_header', 'balance_header'])
            ->get();
        // dd($trialBalances->first()->toArray());
        return view('accounts.reports.cost-center-breakup', compact('balanceIncomeHeaders', 'request', 'fromDate', 'tillDate'));
    }

    public function costCenterSummary(Request $request)
    {
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfMonth();

        $balanceIncomeHeaders = BalanceAndIncomeLine::wherehas('descendants.accounts.currentYearLedger', function ($q) {
            $q->where('cost_center_id', request()->project_id);
        })
            ->with([
                'descendants.accounts.currentYearLedger' => function ($q) {
                    $q->where('cost_center_id', request()->project_id);
                }
            ])
            ->with([
                'descendants.accounts.previousYearLedger' => function ($q) {
                    $q->where('cost_center_id', request()->project_id);
                }
            ])
            ->whereIn('line_type', ['income_header', 'balance_header'])
            ->get();

        return view('accounts.reports.cost-center-summary', compact('balanceIncomeHeaders', 'request', 'fromDate', 'tillDate'));
    }

    public function projectsWip(Request $request)
    {
        // dd(request()->all());
        // $balanceIncomeLineId = request()->line_id ?? 14;

        $balanceIncome = BalanceAndIncomeLine::where('id', request()->line_id)->first();
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfMonth();

        $costCenters = CostCenter::with(['openingBalances' => function ($q) {
            $q->whereHas('account', function ($q) {
                $q->where('balance_and_income_line_id', request()->line_id);
            });
        }])
            ->whereHas('ledgers', function ($q) use ($fromDate, $tillDate) {
                return $q->whereHas('account', function ($q) {
                    $q->where('balance_and_income_line_id', request()->line_id);
                })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                });
            })
            ->with(['ledgers' => function ($q) use ($fromDate, $tillDate) {
                return $q->whereHas('account', function ($q) {
                    $q->where('balance_and_income_line_id', request()->line_id);
                })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                });
            }])
            ->with(['previousLedgers' => function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('account', function ($q) {
                    $q->where('balance_and_income_line_id', request()->line_id);
                })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereDate('transaction_date', '<', $fromDate);
                });
            }])

            ->when(request()->account_id, function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('ledgers', function ($q) use ($fromDate, $tillDate) {
                    return $q->whereHas('account', function ($q) {
                        $q->where('id', request()->account_id);
                    })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                        $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                    });
                });
            })

            ->when(request()->account_id, function ($q) use ($fromDate, $tillDate) {
                $q->with(['ledgers' => function ($q) use ($fromDate, $tillDate) {
                    return $q->whereHas('account', function ($q) {
                        $q->where('id', request()->account_id);
                    })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                        $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                    });
                }]);
            })

            ->when(request()->account_id, function ($q) use ($fromDate) {
                $q->with(['previousLedgers' => function ($q) use ($fromDate) {
                    $q->whereHas('account', function ($q) {
                        $q->where('id', request()->account_id);
                    })->whereHas('transaction', function ($q) use ($fromDate) {
                        $q->whereDate('transaction_date', '<', $fromDate);
                    });
                }]);
            })
            ->get();
        // dd($projectwips->toArray());
        if (request()->reportType == 'pdf') {
            $pdf = PDF::loadView('accounts.reports.projects-wip-pdf', compact('costCenters', 'request', 'fromDate', 'tillDate', 'balanceIncome'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream('project-wip.pdf');
        } elseif (request()->reportType == 'excel') {
            return Excel::download(new ProjectWipExport($fromDate, $tillDate, $costCenters, $balanceIncome), 'project-wip.xlsx');
        } else {
            return view('accounts.reports.projects-wip', compact('costCenters', 'balanceIncome', 'fromDate', 'tillDate'));
        }
    }

    public function balanceIncomeLineReport(Request $request)
    {
        // dd(request()->all());
        // $balanceIncomeLineId = request()->line_id ?? 14;
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfMonth();

        $parentAccounts = Account::where('balance_and_income_line_id', request()->line_id)
            ->with('openingBalance', 'balanceIncome')
            ->whereHas('ledgers', function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                });
            })
            ->with(['ledgers' => function ($q) use ($fromDate, $tillDate) {
                $q->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                    $q->whereBetween('transaction_date', [$fromDate, $tillDate]);
                });
            }])
            ->with(['previousYearLedger' => function ($q) use ($fromDate) {
                $q->whereHas('transaction', function ($q) use ($fromDate) {
                    $q->whereDate('transaction_date', '<', $fromDate);
                });
            }])
            ->get();
        if (request()->reportType == 'pdf') {
            $pdf = PDF::loadView('accounts.reports.balance-income-line-report-pdf', compact('parentAccounts', 'fromDate', 'tillDate'));
            return $pdf->stream('Balance Income Line Report.pdf');
        } elseif (request()->reportType == 'excel') {
            return Excel::download(new BalanceIncomeLineReportExport($parentAccounts, $fromDate, $tillDate), 'Balance Income Line Report.xlsx');
        } else {
            return view('accounts.reports.balance-income-line-report', compact('parentAccounts', 'fromDate', 'tillDate'));
        }
    }

    public function pendingBills()
    {
        $paidBill = LedgerEntry::whereNotNull('ref_bill')->get(['dr_amount', 'ref_bill'])->groupBy('ref_bill')
            ->map(function ($item) {
                return $item->sum('dr_amount');
            })->filter();

        $discount = Transaction::whereHas('ledgerEntries', function ($q) {
            $q->where('pourpose', 'discount');
        })
            ->with(['ledgerEntries' => function ($q) {
                $q->where('pourpose', 'discount');
            }])
            ->get()->groupBy('bill_no')
            ->map(function ($item) {
                return $item->pluck('ledgerEntries')->flatten()->sum('dr_amount');
            });

        $transactions = Transaction::with('ledgerEntries.account', 'paidBill')
            ->whereDoesntHave('ledgerEntries', function ($q) {
                $q->where('pourpose', 'discount');
            })
            ->whereNotNull('bill_no')
            ->withSum('paidBill', 'dr_amount')
            ->withSum('ledgerEntries', 'cr_amount')
            ->where('voucher_type', 'Journal')->latest()
            ->get()
            ->groupBy('bill_no')
            ->map(function ($item, $key) use ($paidBill, $discount) {
                $bill = $item->sum('ledger_entries_sum_cr_amount')  - $discount->get($key, 0);
                if ($paidBill->get($key) <= $bill) {
                    return $item;
                }
                //                return $paidBill->get($key);
            })->filter();

        //        dd($transactions->toArray(), $paidBill->toArray(), $discount->toArray());

        return view('accounts.reports.pending-bills', compact('transactions', 'discount'));
    }

    public function bankLoanStatement()
    {
        $loans = Loan::with('loanable', 'account')->get()
            ->map(function ($item) {
                $loanPayment = $item->account->ledgers->sum('dr_amount');
                $loanAmount = $item->loanReceives->flatten()->sum('receipt_amount');
                $item['loan_amount'] = $loanAmount;
                $interestAccount = $item->account()->where('account_type', 5)->first();
                $totalInterest = $interestAccount->ledgers->sum('dr_amount');
                $item['loan_outstanding'] = $loanAmount + $totalInterest - $loanPayment;
                return $item;
            });
        //        return view('accounts.reports.bank-loan-statement',compact('loans'));
        return PDF::loadview('accounts.reports.bank-loan-statement', compact('loans'))->setPaper('a4', 'landscape')->stream('accounts.loanStatement.pdf');
    }

    public function fixedAssetStatment()
    {
        $month = !empty(request()->month) ? request()->month . '-01' : now()->format('Y-m-d');
        $lastDayofMonth  = date("Y-m-t", strtotime($month));
        $reqFromDate = request()->fromDate ? date('Y-m-d', strtotime(request()->fromDate)) : now()->format('Y-m-01');
        $reqToDate = request()->toDate ? date('Y-m-d', strtotime(request()->toDate)) : date("Y-m-t", strtotime(now()));
        $fromDate = !empty(request()->month) ? request()->month . '-01' : $reqFromDate;
        $toDate = !empty(request()->month) ? $lastDayofMonth : $reqToDate;

        //        dd($fromDate, $toDate);
        $request = \request();
        //        dd($fromDate);

        $fixedAssets = FixedAsset::with('depreciationAccount')
            ->with(['transaction' => function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('transaction_date', [$fromDate, $toDate]);
            }])
            ->with(['previousTransection' => function ($q) use ($fromDate, $toDate) {
                $q->where('transaction_date', '<', $fromDate);
            }])
            ->with(['depreciationDetails' => function ($q) use ($fromDate, $toDate) {
                $q->whereHas('depreciation', function ($q) use ($fromDate, $toDate) {
                    $q->whereBetween('month', [$fromDate, $toDate]);
                });
            }])
            ->with(['previousMonth' => function ($q) use ($fromDate, $toDate) {
                $q->whereHas('depreciation', function ($q) use ($fromDate, $toDate) {
                    $q->where('month', '<', $fromDate);
                });
            }])
            ->get();

        if (request()->reportType == 'pdf') {
            return PDF::loadview('accounts.reports.fixed-asset-statment-pdf', compact('fixedAssets', 'request'))->setPaper('a4', 'landscape')->stream('accounts.fixedAsset.pdf');
        } elseif (request()->reportType == 'excel') {
            return Excel::download(new FixedAssetStatementExport($fixedAssets, $request), 'accounts.fixedAsset.xlsx');
        } else {
            return view('accounts.reports.fixed-asset-statment', compact('fixedAssets', 'request'));
        }

        return view('accounts.reports.fixed-asset-statment', compact('fixedAssets', 'request'));
    }

    public function cashFlowStatement(Request $request)
    {

        //        return \PDF::loadview('accounts.reports.cash-flow-statement-pdf')->stream('accounts.cashflow.pdf');
    }

    public function receiptPaymentStatement(Request $request)
    {
        $fromDate = $request->fromDate ? Carbon::createFromFormat('d-m-Y', $request->fromDate)->startOfDay() : Carbon::now()->startOfMonth();
        $tillDate = $request->tillDate ? Carbon::createFromFormat('d-m-Y', $request->tillDate)->endOfDay() : Carbon::now()->endOfMonth();
        $openingBank = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->where('balance_and_income_line_id', 8);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->where('transaction_date', '<', $fromDate)->whereIn('voucher_type', ['Receipt', 'Payment']);
            })->get();
        $openingCash = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->where('balance_and_income_line_id', 7);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->where('transaction_date', '<', $fromDate)->whereIn('voucher_type', ['Receipt', 'Payment']);
            })->get();

        $receipts = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->whereNotIn('balance_and_income_line_id', [8, 7]);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('transaction_date', [$fromDate, $tillDate])->where('voucher_type', 'Receipt');
            })->latest()->get()->groupBy('account.balance_and_income_line_id');

        $payments = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->whereNotIn('balance_and_income_line_id', [8, 7]);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('transaction_date', [$fromDate, $tillDate])->where('voucher_type', 'Payment');
            })->latest()->get()->groupBy('account.balance_and_income_line_id');

        $paymentTotal = 0;
        foreach ($payments as $payment) {
            $paymentTotal += $payment->sum('dr_amount');
        }

        $closingBank = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->where('balance_and_income_line_id', 8);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('transaction_date', [$fromDate, $tillDate])->whereIn('voucher_type', ['Receipt', 'Payment']);
            })->get();

        $closingCash = LedgerEntry::with('transaction', 'account.balanceIncome')
            ->whereHas('account', function ($q) {
                $q->where('balance_and_income_line_id', 7);
            })->whereHas('transaction', function ($q) use ($fromDate, $tillDate) {
                $q->whereBetween('transaction_date', [$fromDate, $tillDate])->whereIn('voucher_type', ['Receipt', 'Payment']);
            })->get();
        //        dd($openingCash->sum('dr_amount') - $openingCash->sum('cr_amount'));

        return view('accounts.reports.cash-flow-statement', compact(
            'request',
            'receipts',
            'payments',
            'openingBank',
            'openingCash',
            'paymentTotal',
            'closingBank',
            'closingCash'
        ));
    }
}
