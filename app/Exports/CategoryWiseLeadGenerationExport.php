<?php

namespace App\Exports;

use App\Sells\LeadGeneration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;




class CategoryWiseLeadGenerationExport implements FromView
{
    public $data;
    public $month;
    public $year;

    public function __construct($data, $year, $month)
    {
        $this->data = $data;
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        return view('sales.sales-report.category-wise-lead-generation-reportpdf', [
            'category_wise_leads' => $this->data,
            'year' => $this->year,
            'month' => $this->month
        ]);
    }
}
