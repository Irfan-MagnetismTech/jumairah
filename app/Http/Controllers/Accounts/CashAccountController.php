<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\CashAccount;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashAccountController extends Controller
{

    public function index()
    {
        $cashAccounts = CashAccount::latest()->get();
        return view('accounts.cashAccounts.index', compact('cashAccounts'));
    }

    public function create()
    {
        $formType = "create";
        return view('accounts.cashAccounts.create', compact('formType'));
    }


    public function store(Request $request)
    {
        try{
            $data = $request->all();
            CashAccount::create($data);
            return redirect()->route('cashAccounts.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('cashAccounts.create')->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(CashAccount $cashAccount)
    {
        //
    }


    public function edit(CashAccount $cashAccount)
    {
        $formType = "edit";
        return view('accounts.cashAccounts.create', compact('formType','cashAccount'));
    }


    public function update(Request $request, CashAccount $cashAccount)
    {
        try{
            $data = $request->all();
            $cashAccount->update($data);
            return redirect()->route('cashAccounts.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('cashAccounts.create')->withInput()->withErrors($e->getMessage());
        }
    }


    public function destroy(CashAccount $cashAccount)
    {
        try{
            $cashAccount->delete();
            return redirect()->route('cashAccounts.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('cashAccounts.index')->withErrors($e->getMessage());
        }
    }
}
