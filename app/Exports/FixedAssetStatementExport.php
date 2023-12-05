<?php

namespace App\Exports;

use App\FixedAsset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FixedAssetStatementExport implements FromView
{
    public $fixedAssets;
    public $request;

    public function __construct($fixedAssets, $request)
    {
        $this->fixedAssets = $fixedAssets;
        $this->request = $request;
    }

    public function view(): View
    {
        return view('accounts.reports.fixed-asset-statment-excel', [
            'fixedAssets' => $this->fixedAssets,
            'request' => $this->request,
        ]);
    }
}
