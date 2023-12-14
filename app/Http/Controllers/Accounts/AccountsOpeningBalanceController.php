<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\AccountsOpeningBalance;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsOpeningBalanceController extends Controller
{
    public function index()
    {
        $openingBalances = AccountsOpeningBalance::with('account')->latest()->get() ;
        return view('accounts.accounts-opening-balances.index',compact('openingBalances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.accounts-opening-balances.create');
    }

    public function store(Request $request)
    {
        try{
            DB::transaction(function()use($request){
                foreach ($request->cost_center_id as  $key => $detail){
                    $entries =[
                        'account_id' => $request->account_id,
                        'date' => $request->date,
                        'cost_center_id'=>$request->cost_center_id[$key],
                        'dr_amount'=>$request->dr_amount[$key] ?? null,
                        'cr_amount'=>$request->cr_amount[$key] ?? null,
                        'user_id'=>auth()->user()->id,
                    ];
                    AccountsOpeningBalance::create($entries);
                }
            });
            return redirect()->route('account-opening-balances.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(AccountsOpeningBalance $accountOpeningBalance)
    {
        //
    }

    public function edit(AccountsOpeningBalance $accountOpeningBalance)
    {
//        dd($accountOpeningBalance);
        return view('accounts.accounts-opening-balances.create', compact('accountOpeningBalance'));
    }

    public function update(Request $request, AccountsOpeningBalance $accountOpeningBalance)
    {
        try{
            $entries = $request->only('account_id','date','cost_center_id','dr_amount','cr_amount');
            DB::transaction(function()use($entries, $accountOpeningBalance){
                $accountOpeningBalance->update($entries);
            });
            return redirect()->route('account-opening-balances.index')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(AccountsOpeningBalance $accountOpeningBalance)
    {
        try{
            $accountOpeningBalance->delete();
            return redirect()->route('account-opening-balances.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
