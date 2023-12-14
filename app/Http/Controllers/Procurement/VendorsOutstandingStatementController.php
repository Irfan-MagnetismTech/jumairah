<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Procurement\Supplierbillofficebilldetails;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorsOutstandingStatementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:vendors-outstanding-statement', ['only' => ['statement','getReport']]);
    }
    public function statement()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
    
        $totalBillOutstanding =  LedgerEntry::with('account')->whereHas('transaction', function ($q) use($currentDate){
                                $q->whereDate('transaction_date', '<=', $currentDate);                            
                              })->whereHas('account', function ($q){
                                  $q->where('balance_and_income_line_id', 34)
                                  ->where('parent_account_id',101);
                              })->get()
                              ->groupBy(['account_id'])
                              ->map(fn($items, $key) => 
                                    [   
                                        'account_name'  => $items->flatten()->first()->account->account_name,
                                        'total_amount' => $items->sum('cr_amount') - $items->sum('dr_amount')
                                    ]
                            );

    return view('procurement.vendors-outstanding.index', compact('totalBillOutstanding'));

    }

    public function getReport(Request $request)
    {
        $fromdate = $this->formatDate($request->fromdate);
        $todate =  $this->formatDate($request->todate);

        $totalBillOutstanding =  LedgerEntry::with('account')->whereHas('transaction', function ($q) use($fromdate, $todate){
                                $q->whereBetween('transaction_date', [$fromdate, $todate]);                            
                              })->whereHas('account', function ($q){
                                  $q->where('balance_and_income_line_id', 34)
                                  ->where('parent_account_id',101);
                              })->get()
                              ->groupBy(['account_id'])
                              ->map(fn($items, $key) => 
                                    [   
                                        'account_name'  => $items->flatten()->first()->account->account_name,
                                        'total_amount' => $items->sum('cr_amount') - $items->sum('dr_amount')
                                    ]
                            );
        $dates =[
            'fromdate' => $fromdate,
            'todate' => $todate,
        ];

    return view('procurement.vendors-outstanding.report', compact('totalBillOutstanding', 'fromdate', 'todate', 'dates'));
    }

    public function pdf(Request $request)
    {
        $fromdate = $request->dates['fromdate'];
        $todate = $request->dates['todate'];

        $totalBillOutstanding =  LedgerEntry::with('account')->whereHas('transaction', function ($q) use($fromdate, $todate){
                                $q->whereBetween('transaction_date', [$fromdate, $todate]);                            
                              })->whereHas('account', function ($q){
                                  $q->where('balance_and_income_line_id', 34)
                                  ->where('parent_account_id',101);
                              })->get()
                              ->groupBy(['account_id'])
                              ->map(fn($items, $key) => 
                                    [   
                                        'account_name'  => $items->flatten()->first()->account->account_name,
                                        'total_amount' => $items->sum('cr_amount') - $items->sum('dr_amount')
                                    ]
                            );

    return \PDF::loadview('procurement.vendors-outstanding.pdf', compact('totalBillOutstanding', 'fromdate', 'todate'))->setPaper('A4', 'portrait')->stream('Vendors-Outstanding-Copy.pdf');
    }

    private function formatDate(string $date): string
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
