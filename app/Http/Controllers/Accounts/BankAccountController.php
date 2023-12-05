<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\Accounts\BankAccount;
use App\Bank;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Procurement\NestedMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{

    public function index(){
        $bankAccounts = BankAccount::latest()->get();
        return view('accounts.bankAccounts.index', compact('bankAccounts'));
    }


    public function create()
    {
        $formType = "create";
        return view('accounts.bankAccounts.create', compact('formType'));
    }


    public function store(BankAccountRequest $request)
    {
        // dd($request->all());
        try{
            $data = $request->only('account_type','name','branch_name','account_name','account_number','swift_code','routing_number');

            $accountData['account_type']= '1';
            $accountData['account_name']= $request->name .' - CD A/C - '.$request->account_number ;
            $accountData['balance_and_income_line_id']= 8;

            DB::transaction(function() use($data, $accountData){
                $bank = BankAccount::create($data);
                $accountData['account_code'] = "1-5-8-$bank->id";
                $bank->account()->create($accountData);
            });


            return redirect()->route('bankAccounts.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('bankAccounts.create')->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(BankAccount $bankAccount)
    {
        //
    }


    public function edit(BankAccount $bankAccount)
    {
        $formType = "edit";
        return view('accounts.bankAccounts.create', compact('formType','bankAccount'));
    }


    public function update(BankAccountRequest $request, BankAccount $bankAccount)
    {
        try{
            $data = $request->all();

            $accountData['account_type']= '1';
            $accountData['account_name']= $request->name .' - CD A/C - '.$request->account_number ;
            $accountData['balance_and_income_line_id']= 8;

            DB::transaction(function()use($data, $accountData,  $bankAccount){
                $bankAccount->update($data);
                $accountData['account_code'] = "1-5-8-$bankAccount->id";
                $bankAccount->account()->updateOrCreate(
                    ['accountable_type'=>BankAccount::class,'accountable_id'=>$bankAccount->id],
                    $accountData
                );
            });

            return redirect()->route('bankAccounts.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('bankAccounts.create')->withInput()->withErrors($e->getMessage());
        }
    }


    public function destroy(BankAccount $bankAccount)
    {
        try{
            DB::transaction(function () use ($bankAccount){
                $bankAccount->account()->delete();
                $bankAccount->delete();
            });

            return redirect()->route('bankAccounts.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bankAccounts.index')->withErrors($e->getMessage());
        }
    }

}
