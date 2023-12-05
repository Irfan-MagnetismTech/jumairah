<?php

namespace App\Exports;

use App\CostCenter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectWipExport implements FromView
{
    public $fromDate;
    public $tillDate;
    public $costCenters;
    public $balanceIncome;

    public function __construct($fromDate, $tillDate, $costCenters, $balanceIncome)
    {
        $this->fromDate = $fromDate;
        $this->tillDate = $tillDate;
        $this->costCenters = $costCenters;
        $this->balanceIncome = $balanceIncome;
    }

    public function view(): View
    {
        return view('accounts.reports.projects-wip-excel', [
            'fromDate' => $this->fromDate,
            'tillDate' => $this->tillDate,
            'costCenters' => $this->costCenters,
            'balanceIncome' => $this->balanceIncome
        ]);
    }
}
