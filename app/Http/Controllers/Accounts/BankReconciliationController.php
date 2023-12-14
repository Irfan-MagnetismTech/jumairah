<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\BankReconciliation;
use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankReconciliationController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('ledgerEntries.account','bankReconciliation')
                ->wherehas('ledgerEntries.account', function ($q){
                    $q->where('balance_and_income_line_id',8);
                })
                ->whereIn('voucher_type', ['Receipt','Payment','Contra'])->latest()->get();

        return view('accounts.bank-reconciliations.index',compact('transactions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            $transaction = $request->only('date','transaction_id');
            $transaction['user_id'] = auth()->user()->id;
            $transaction['status'] = 'Complete';
            DB::transaction(function()use($transaction){
                BankReconciliation::create($transaction);
            });
            return redirect()->route('bank-reconciliations.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(BankReconciliation $bankReconciliation )
    {
        dd($bankReconciliation);
    }

    public function edit(BankReconciliation $bankReconciliation)
    {
        //
    }

    public function update(Request $request, BankReconciliation $bankReconciliation)
    {
        //
    }

    public function destroy(BankReconciliation $bankReconciliation)
    {
        //
    }

    public function bankReconciliationsPdf()
    {
        $transactions = Transaction::with('ledgerEntries.account','bankReconciliation')
            ->whereIn('voucher_type', ['Receipt','Payment','Contra'])->latest()->get();

        $transactionBanks = Transaction::with('ledgerEntries.account')
            ->doesntHave('bankReconciliation')
            ->whereIn('voucher_type', ['Receipt','Payment','Contra'])->latest()
            ->get();

//        dd($transactionBanks);
//    return view('accounts.bank-reconciliations.reconciliationPdf',compact('transactions','transactionBanks'));
        return \PDF::loadview('accounts.bank-reconciliations.reconciliationPdf',compact('transactions','transactionBanks'))->setPaper('a4', 'landscape')->stream('accounts.BankReconciliation.pdf');
    }
}
