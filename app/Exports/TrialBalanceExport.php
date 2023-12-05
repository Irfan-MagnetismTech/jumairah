<?php

namespace App\Exports;

use App\BalanceAndIncomeLine;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TrialBalanceExport implements FromView
{
    public $fromDate;
    public $tillDate;
    public $balanceIncomeHeaders;

    public function __construct($fromDate, $tillDate, $balanceIncomeHeaders)
    {
        $this->fromDate = $fromDate;
        $this->tillDate = $tillDate;
        $this->balanceIncomeHeaders = $balanceIncomeHeaders;
    }

    public function view(): View
    {
        return view('accounts.reports.trial-balance-excel', [
            'fromDate' => $this->fromDate,
            'tillDate' => $this->tillDate,
            'balanceIncomeHeaders' => $this->balanceIncomeHeaders
        ]);
    }
}
