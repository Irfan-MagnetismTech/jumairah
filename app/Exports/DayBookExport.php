<?php

namespace App\Exports;

use App\LedgerEntry;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DayBookExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $fromDate;
    public $tillDate;
    public $ledgetEntries;

    public function __construct($fromDate, $tillDate, $ledgetEntries)
    {
        $this->fromDate = $fromDate;
        $this->tillDate = $tillDate;
        $this->ledgetEntries = $ledgetEntries;
    }

    public function view(): View
    {
        return view('accounts.reports.day-book-excel', [
            'fromDate' => $this->fromDate,
            'tillDate' => $this->tillDate,
            'ledgetEntries' => $this->ledgetEntries
        ]);
    }
}
