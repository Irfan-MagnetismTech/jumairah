<?php

namespace App\Exports;

use App\Account;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BalanceIncomeLineReportExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $fromDate;
    public $tillDate;
    public $parentAccounts;

    public function __construct($parentAccounts, $fromDate, $tillDate)
    {
        $this->fromDate = $fromDate;
        $this->tillDate = $tillDate;
        $this->parentAccounts = $parentAccounts;
    }
    public function view(): View
    {
        return view('accounts.reports.balance-income-line-report-excel', [
            'parentAccounts' => $this->parentAccounts,
            'fromDate' => $this->fromDate,
            'tillDate' => $this->tillDate
        ]);
    }
}
