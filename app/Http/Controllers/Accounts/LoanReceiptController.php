<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\BankAccount;
use App\Accounts\Loan;
use App\Accounts\LoanReceipt;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanReceiptRequest;
use App\Http\Requests\UpdateLoanReceiptRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Accounts;

class LoanReceiptController extends Controller
{
    public function index()
    {
        $loanReceives = LoanReceipt::latest()->get();
        return view('accounts.loan-receipts.index', compact('loanReceives'));
    }

    public function create()
    {
        $loans = Account::where('accountable_type',Loan::class)->where('account_type','!=','5')->pluck('account_name','accountable_id');
        $bankAccounts = Account::whereIn('balance_and_income_line_id',[8,31])->pluck('account_name','id');
        return view('accounts.loan-receipts.create', compact('loans','bankAccounts'));
    }

    public function store(StoreLoanReceiptRequest $request)
    {
        try{
            $data = $request->all();
            $transection['voucher_type'] = 'Receipt';
            $transection['transaction_date'] = $request->date;
            $transection['cheque_number'] = $request->cheque_number;
            $transection['cheque_type'] = $request->cheque_type;
            $transection['cheque_date'] = $request->cheque_date;
            $transection['user_id'] = auth()->user()->id;
            $data['user_id'] = auth()->user()->id;

            $crAccount = Account::where('accountable_type',Loan::class)->where('accountable_id',$request->loan_id)->first();
            $debitLedger['account_id'] = $request->account_id;
            $debitLedger['dr_amount'] = $request->receipt_amount;

            $creditLedger['account_id'] = $crAccount->id;
            $creditLedger['cr_amount'] = $request->receipt_amount;

            DB::transaction(function()use($data,$request,$transection,$debitLedger,$creditLedger){
                $loanReceive = LoanReceipt::create($data);
                $transectionData = $loanReceive->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
            });

            return redirect()->route('loans.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('loans.create')->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(LoanReceipt $loanReceipt)
    {

    }

    public function edit(LoanReceipt $loanReceipt)
    {
//        dd($loanReceipt->loan);
        $loans = Account::where('accountable_type',Loan::class)->where('account_type','!=','5')->pluck('account_name','accountable_id');
        $bankAccounts = Account::whereIn('balance_and_income_line_id',[8,31])->pluck('account_name','id');
        return view('accounts.loan-receipts.create', compact('loans','bankAccounts','loanReceipt'));
    }

    public function update(UpdateLoanReceiptRequest $request, LoanReceipt $loanReceipt)
    {
        try{
            $data = $request->all();
            $transection['voucher_type'] = 'Receipt';
            $transection['transaction_date'] = $request->date;
            $transection['cheque_number'] = $request->cheque_number;
            $transection['cheque_type'] = $request->cheque_type;
            $transection['cheque_date'] = $request->cheque_date;
            $transection['user_id'] = auth()->user()->id;
            $data['user_id'] = auth()->user()->id;

            $crAccount = Account::where('accountable_type',Loan::class)->where('accountable_id',$request->loan_id)->first();
            $debitLedger['account_id'] = $request->account_id;
            $debitLedger['dr_amount'] = $request->receipt_amount;

            $creditLedger['account_id'] = $crAccount->id;
            $creditLedger['cr_amount'] = $request->receipt_amossunt;

            DB::transaction(function()use($data,$request,$transection,$debitLedger,$loanReceipt, $creditLedger){
                $loanReceipt->update($data);
                $loanReceipt->transaction()->delete();
                $transectionData = $loanReceipt->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
            });

            return redirect()->route('loan-receipts.index')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(LoanReceipt $loanReceipt)
    {
        try{
            if ($loanReceipt->transaction()->exists()){
                return redirect()->route('loan-receipts.index')->with('error', 'Please Remove Received Transaction First');
            }else{
                $loanReceipt->transaction()->delete();
                $loanReceipt->delete();
                return redirect()->route('loans.index')->with('message', 'Data has been deleted successfully');
            }

        }catch(QueryException $e){
            return redirect()->route('loans.index')->withErrors($e->getMessage());
        }
    }
}
