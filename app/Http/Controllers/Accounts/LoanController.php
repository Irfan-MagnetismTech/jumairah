<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\BankAccount;
use App\Accounts\InterCompany;
use App\Accounts\Loan;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{

    public function index()
    {
        $loans = Loan::latest()->get();
        return view('accounts.loans.index', compact('loans'));
    }

    public function create()
    {
        $sourcenames = [];
        $projects = Project::pluck('name','id');
        $sources = ['Bank'=>'Bank','Inter Company'=>'Inter Company'];
        $loanTypes = ['SOD' => 'SOD','Lease Finance' => 'Lease Finance','HBL' => 'HBL','LTR' => 'LTR'];
        return view('accounts.loans.create', compact('sourcenames','projects','loanTypes','sources'));
    }

    public function store(LoanRequest $request)
    {
        try{
            $data = $request->all();
            $data['loanable_type'] = $request->loanable_type ?  BankAccount::class : InterCompany::class;
            $data['loanable_id'] = $request->loanable_id;

            $accountData['account_type']= '2';

            $accountInterest['account_type']= '5';
            $accountInterest['balance_and_income_line_id']= 87;

            DB::transaction(function()use($data, $accountData, $accountInterest, $request){
                $loan = Loan::create($data);
                $loanName = $loan->loanable->name. ' - ' .$request->loan_type . ' - '. $request->loan_number;
                $accountInterest['account_name']= 'Bank Interest - '.$loanName;
                $accountInterest['account_code']= '74-85-87-'.$loan->id;
                $accountInterest['loan_type']= "$request->loan_type";

                if ($request->loan_type == 'SOD'){
                    $accountData['balance_and_income_line_id']= 31;
                    $accountData['account_code']= '26-33-31-'.$loan->id;
                }elseif ($request->loan_type == 'Lease Finance'){
                    $accountData['balance_and_income_line_id']= 43;
                    $accountData['account_code']= '26-42-43-'.$loan->id;
                }elseif ($request->loan_type == 'HBL'){
                    $accountData['balance_and_income_line_id']= 44;
                    $accountData['account_code']= '26-42-44-'.$loan->id;
                }elseif ($request->loan_type == 'LTR'){
                    $accountData['balance_and_income_line_id']= 32;
                    $accountData['account_code']= '26-30-32-'.$loan->id;
                }
                $accountData['account_name']= $loanName;
                $loan->update(['name'=>"$loanName"]);
                $loan->account()->create($accountData);
                $loan->account()->create($accountInterest);
            });

            return redirect()->route('loans.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('loans.create')->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Loan $loan)
    {
        //
    }

    public function edit(Loan $loan)
    {
        $sourcenames = $loan->loanable_type == "App\Accounts\BankAccount" ? BankAccount::orderBy('name')->get()->pluck('loan_number', 'id')  :
                InterCompany::orderBy('name')->pluck('name', 'id');
        $projects = Project::pluck('name','id');
        $sources = ['Bank'=>'Bank','Inter Company'=>'Inter Company'];
        $loanTypes = ['SOD' => 'SOD','Lease Finance' => 'Lease Finance','HBL' => 'HBL','LTR' => 'LTR'];
        return view('accounts.loans.create', compact('projects','loanTypes', 'sources','sourcenames', 'loan'));
    }

    public function update(LoanRequest $request, Loan $loan)
    {
        try{
            $data = $request->all();
            $data['loanable_type'] = $request->loanable_type ?  BankAccount::class : InterCompany::class;
            $data['loanable_id'] = $request->loanable_id;

            $accountData['account_type']= '2';

            $accountInterest['account_type']= '5';
            $accountInterest['balance_and_income_line_id']= 87;

            DB::transaction(function () use($accountInterest, $accountData, $data, $loan, $request){
                $loan->account()->delete();
                $loanName = $loan->loanable->name. ' - ' .$request->loan_type . ' - '. $request->loan_number;
                $data['name'] = $loanName;
                $loan->update($data);
                $accountInterest['account_name']= 'Bank Interest - '.$loanName;
                $accountInterest['account_code']= '74-85-87-'.$loan->id;
                $accountInterest['loan_type']= "$request->loan_type";

                if ($request->loan_type == 'SOD'){
                    $accountData['balance_and_income_line_id']= 31;
                    $accountData['account_code']= '26-33-31-'.$loan->id;
                }elseif ($request->loan_type == 'Lease Finance'){
                    $accountData['balance_and_income_line_id']= 43;
                    $accountData['account_code']= '26-42-43-'.$loan->id;
                }elseif ($request->loan_type == 'HBL'){
                    $accountData['balance_and_income_line_id']= 44;
                    $accountData['account_code']= '26-42-44-'.$loan->id;
                }elseif ($request->loan_type == 'LTR'){
                    $accountData['balance_and_income_line_id']= 32;
                    $accountData['account_code']= '26-30-32-'.$loan->id;
                }

                // dd($accountInterest);
                $accountData['account_name']= $loanName;
                $loan->account()->create($accountData);
                $loan->account()->create($accountInterest);
            });

            return redirect()->route('loans.index')->with('message', 'Data has been Update successfully');
        }catch(QueryException $e){
            return redirect()->route('loans.create')->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Loan $loan)
    {
        try{
            if ($loan->loanReceives()->exists()){
                return redirect()->route('loans.index')->with('error', 'Please Remove Loan Received First');
            }else{
                $loan->account()->delete();
                $loan->delete();
                return redirect()->route('loans.index')->with('message', 'Data has been deleted successfully');
            }

        }catch(QueryException $e){
            return redirect()->route('loans.index')->withErrors($e->getMessage());
        }
    }
}
