<?php

namespace App\Http\Controllers\Accounts;

use App\Apsection;
use App\Bank;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Procurement\Supplierbill;
use App\Procurement\Supplierbillofficebilldetails;
use App\Transaction;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('ledgerEntries.account', 'ledgerEntries.costCenter')->latest()->get();
        // dd($transactions);
        return view('accounts.vouchers.index',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bills = Supplierbill::pluck('bill_no','bill_no');
        $refBills = Transaction::where('voucher_type','Journal')->where('bill_no','!=',null)->pluck('bill_no','bill_no');
        $types = ['Receipt'=>'Receipt', 'Payment'=>'Payment', 'Journal'=>'Journal', 'Contra'=>'Contra'];

        return view('accounts.vouchers.create', compact('types','bills','refBills'));
    }

    public function store(Request $request){
        try{
            $transaction = $request->only('voucher_type', 'transaction_date','bill_no', 'mr_no','narration','cheque_number','cheque_type','cheque_date');
            $transaction['user_id'] = auth()->user()->id;
            $ledgerEntries=array();

            foreach ($request->account_id as  $key => $detail){
                $ledgerEntries[]=[
                    'account_id'=>$request->account_id[$key],
                    'dr_amount'=>$request->dr_amount[$key] ?? null,
                    'cr_amount'=>$request->cr_amount[$key] ?? null,
                    'ref_bill'=>$request->ref_bill[$key] ?? null,
                    'cost_center_id'=>$request->cost_center_id[$key],
                    'remarks'=>$request->remarks[$key],
                ];



            }
//             dd($transaction, $ledgerEntries);
            DB::transaction(function()use($transaction, $ledgerEntries, $request){
                $transactionData = Transaction::create($transaction);
                $transactionData->ledgerEntries()->createMany($ledgerEntries);
                $paidBills=[];
                $i=0;
                foreach($transactionData->ledgerEntries as $key => $ledger){
                    $paidBills = [
                        'account_id' => $ledger->account_id,
                        'cost_center_id' => $ledger->cost_center_id,
                        'ref_bill' => $request->ref_bill[$i++] ?? '',
                        'amount' => $ledger->dr_amount ?? 0,
                    ];

                    if($ledger->account->balance_and_income_line_id == 34 && $transactionData->voucher_type == 'Payment'){
                        $transactionData->paidBillTransections()->create($paidBills);
                    }
                }

            });
            return redirect()->route('vouchers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Transaction  $voucher)
    {
        $f = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);

         return view('accounts.vouchers.show', compact('voucher','f'));
    }


    public function edit( Transaction  $voucher)
    {
        $bills = Supplierbill::pluck('bill_no','bill_no');
        $refBills = Transaction::where('voucher_type','Journal')->where('bill_no','!=',null)->pluck('bill_no','bill_no');
        $types = ['Receipt'=>'Receipt', 'Payment'=>'Payment', 'Journal'=>'Journal', 'Contra'=>'Contra'];
        return view('accounts.vouchers.create', compact('bills','voucher','types','refBills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transactionId)
    {
        try{
            $transaction = Transaction::where('id', $transactionId)->first();
            $transactionData = $request->only('voucher_type', 'transaction_date', 'narration','cheque_number','cheque_type','cheque_date');
            $ledgerEntries=array();
            $paidBills=[];
            foreach ($request->account_id as  $key => $detail){
                $ledgerEntries[]=[
                    'account_id'=>$request->account_id[$key],
                    'dr_amount'=>$request->dr_amount[$key],
                    'cr_amount'=>$request->cr_amount[$key],
                    'ref_bill'=>$request->ref_bill[$key] ?? null,
                    'cost_center_id'=>$request->cost_center_id[$key],
                    'remarks'=>$request->remarks[$key],
                ];

                if (!empty($request->ref_bill[$key])){
                    $paidBills[] = [
                        'account_id' => $request->account_id[$key],
                        'cost_center_id' => $request->cost_center_id[$key] ?? null,
                        'ref_bill' => $request->ref_bill[$key] ?? null,
                        'amount' => $request->dr_amount[$key] ?? null,
                    ];
                }
            }
            DB::transaction(function()use($transaction, $transactionData, $ledgerEntries, $paidBills){
                $transaction->update($transactionData);
                $transaction->ledgerEntries()->delete();
                $transaction->ledgerEntries()->createMany($ledgerEntries);
                if ($transaction->paidBillTransections()->exists()){
                    $transaction->paidBillTransections()->delete();
                }
                if(count($paidBills) > 0){
                    $transaction->paidBillTransections()->createMany($paidBills);
                }
            });
            return redirect()->route('vouchers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($transactionId)
    {
        try{
            $transaction = Transaction::where('id', $transactionId)->first();
            $transaction->delete();
            return redirect()->route('vouchers.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
