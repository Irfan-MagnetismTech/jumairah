<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MisReportController extends Controller
{
    public function misCorrection()
    {
        return view('accounts.mis-reports.mis-correction');
    }

    public function misSummary()
    {
        return view('accounts.mis-reports.mis-summary');
    }

    public function misHrReport()
    {
        return view('accounts.mis-reports.mis-hr-report');
    }

    public function budgetCashFlow()
    {
                return \PDF::loadview('accounts.mis-reports.budgetCashFlow')->setPaper('a4', 'landscape')->stream('accounts.budgetCashFlow.pdf');
//        return view('accounts.mis-reports.budgetCashFlow');
    }
    public function budgetComparisonStatement(Request $request)
    {
//                return \PDF::loadview('accounts.mis-reports.budgetCashFlow')->setPaper('a4', 'landscape')->stream('accounts.budgetCashFlow.pdf');
        return view('accounts.mis-reports.budget-comparison-statement',compact('request'));
    }

}
