<?php

namespace App\Exports;

use App\BalanceAndIncomeLine;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncomeStatementExport implements FromView
{
    public $directIncomes;
    public $directIncomeServices;
    public $indirectIncomes;
    public $directExpenses;
    public $directExpServices;
    public $indirectExpenses;

    public function __construct($directIncomes, $directIncomeServices, $indirectIncomes, $directExpenses, $directExpServices, $indirectExpenses)
    {
        $this->directIncomes = $directIncomes;
        $this->directIncomeServices = $directIncomeServices;
        $this->indirectIncomes = $indirectIncomes;
        $this->directExpenses = $indirectIncomes;
        $this->directExpServices = $indirectIncomes;
        $this->indirectExpenses = $indirectIncomes;
    }

    public function view(): View
    {
        return view('accounts.reports.profit-and-loss_excel', [
            'directIncomes' => $this->directIncomes,
            'directIncomeServices' => $this->directIncomeServices,
            'indirectIncomes' => $this->indirectIncomes,
            'directExpenses' => $this->directExpenses,
            'directExpServices' => $this->directExpServices,
            'indirectExpenses' => $this->indirectExpenses,
        ]);
    }
}
