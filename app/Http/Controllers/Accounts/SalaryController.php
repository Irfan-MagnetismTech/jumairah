<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\Salary;
use App\Accounts\SalaryHead;
use App\CostCenter;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaryRequest;
use App\Http\Requests\UpdateSalaryRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Accounts;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salaries = Salary::latest()->get();
        return  view('accounts.salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salaryHeads = SalaryHead::pluck('name','id');
        return view('accounts.salaries.create', compact('salaryHeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalaryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalaryRequest $request)
    {
        try{
//            dd($request->month);
            $salaryData['month'] = $request->month.'-01';
            $salaryData['user_id'] = auth()->user()->id;

            DB::transaction(function()use($request, $salaryData){
                $salary = Salary::create($salaryData);

                $salaries=array();
                foreach ($request->salary_head_id as  $key => $detail){
                    $salaries[]=[
                        'salary_head_id'=>$request->salary_head_id[$key] ?? null,
                        'unique_key'=>$salary->id. '_' .$request->salary_head_id[$key] ?? null,
                        'gross_salary'=>$request->gross_salary[$key] ?? null,
                        'fixed_allow'=>$request->fixed_allow[$key] ?? null,
                        'area_bonus'=>$request->area_bonus[$key] ?? null,
                        'other_refund'=>$request->other_refund[$key] ?? null,
                        'less_working_day'=>$request->less_working_day[$key] ?? null,
                        'payable'=>$request->payable[$key] ?? null,
                        'pf'=>$request->pf[$key] ?? null,
                        'other_deduction'=>$request->other_deduction[$key] ?? null,
                        'lwd_deduction'=>$request->lwd_deduction[$key] ?? null,
                        'advance_salary'=>$request->advance_salary[$key] ?? null,
                        'ait'=>$request->ait[$key] ?? null,
                        'mobile_bill'=>$request->mobile_bill[$key] ?? null,
                        'canteen'=>$request->canteen[$key] ?? null,
                        'pick_drop'=>$request->pick_drop[$key] ?? null,
                        'loan_deduction'=>$request->loan_deduction[$key] ?? null,
                        'total_deduction'=>$request->total_deduction[$key] ?? null,
                        'net_payable'=>$request->net_payable[$key] ?? null,
                        'remarks'=>$request->remarks[$key] ?? null,
                    ];
                }

                $salary->salaryDetails()->createMany($salaries);
            });
            return redirect()->route('salaries.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {

        $salaryHeads = SalaryHead::pluck('name','id');
        return view('accounts.salaries.create', compact('salaryHeads', 'salary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalaryRequest  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalaryRequest $request, Salary $salary)
    {
        try{
            $salaryData['month'] = $request->month.'-01';
            $salaryData['user_id'] = auth()->user()->id;

            DB::transaction(function()use($request, $salaryData, $salary){
                $salary->update($salaryData);
                $salary->salaryDetails()->delete();
                $salaries=array();
                foreach ($request->salary_head_id as  $key => $detail){
                    $salaries[]=[
                        'salary_head_id'=>$request->salary_head_id[$key] ?? null,
                        'unique_key'=>$salary->id. '_' .$request->salary_head_id[$key] ?? null,
                        'gross_salary'=>$request->gross_salary[$key] ?? null,
                        'fixed_allow'=>$request->fixed_allow[$key] ?? null,
                        'area_bonus'=>$request->area_bonus[$key] ?? null,
                        'other_refund'=>$request->other_refund[$key] ?? null,
                        'less_working_day'=>$request->less_working_day[$key] ?? null,
                        'payable'=>$request->payable[$key] ?? null,
                        'pf'=>$request->pf[$key] ?? null,
                        'other_deduction'=>$request->other_deduction[$key] ?? null,
                        'lwd_deduction'=>$request->lwd_deduction[$key] ?? null,
                        'advance_salary'=>$request->advance_salary[$key] ?? null,
                        'ait'=>$request->ait[$key] ?? null,
                        'mobile_bill'=>$request->mobile_bill[$key] ?? null,
                        'canteen'=>$request->canteen[$key] ?? null,
                        'pick_drop'=>$request->pick_drop[$key] ?? null,
                        'loan_deduction'=>$request->loan_deduction[$key] ?? null,
                        'total_deduction'=>$request->total_deduction[$key] ?? null,
                        'net_payable'=>$request->net_payable[$key] ?? null,
                        'remarks'=>$request->remarks[$key] ?? null,
                    ];
                }
                $salary->salaryDetails()->createMany($salaries);
            });
            return redirect()->route('salaries.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        try{
            $salary->delete();
            return redirect()->route('salaries.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function salaryApproval($id)
    {
        try{
            $salary = Salary::where('id',$id)->first();
            $salaryStatus['status'] = 'Approved';

            $transectionData['voucher_type'] = 'Journal';
            $transectionData['transaction_date'] = now()->format('d-m-Y');
            $transectionData['user_id'] = auth()->user()->id;

            $debitAccount = Account::where('account_name', 'like', "%Salary & Allowances%")->where('balance_and_income_line_id',86)->first();
            $creditAccount = Account::where('account_name', 'like', "%Salary & Allowances Payable%")->where('balance_and_income_line_id',36)->first();
//            dd($debitAccount, $creditAccount);
            $costCenter = CostCenter::where('name', 'like', "%Head Office%")->first();

//            dd($salary->salaryDetails->flatten()->sum('gross_salary'));

            $ledgerDebit['account_id'] = $debitAccount->id;
            $ledgerDebit['dr_amount'] = $salary->salaryDetails->flatten()->sum('gross_salary');
            $ledgerDebit['cost_center_id'] = $costCenter->id;

            $ledgerCredit['account_id'] = $creditAccount->id;
            $ledgerCredit['cr_amount'] = $salary->salaryDetails->flatten()->sum('gross_salary');
            $ledgerCredit['cost_center_id'] = $costCenter->id;

            DB::transaction(function()use($salaryStatus,$salary,$transectionData, $ledgerDebit, $ledgerCredit){
                $transection = $salary->transaction()->create($transectionData);
                $transection->ledgerEntries()->create($ledgerDebit);
                $transection->ledgerEntries()->create($ledgerCredit);
                Salary::where('id',$salary->id)->update($salaryStatus);
            });
            return redirect()->route('salaries.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
