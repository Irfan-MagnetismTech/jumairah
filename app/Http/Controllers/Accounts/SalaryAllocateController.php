<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\Allocation;
use App\Accounts\Salary;
use App\Accounts\SalaryAllocate;
use App\CostCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaryAllocateRequest;
use App\Http\Requests\UpdateSalaryAllocateRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SalaryAllocateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = SalaryAllocate::latest()->get();
        return view('accounts.salaryAllocates.index',compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.salaryAllocates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalaryAllocateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalaryAllocateRequest $request)
    {
        try{
            $month = $request->month.'-01';
            $m = date('m', strtotime($month));
            $year = date('Y', strtotime($month));
            $allocation = Salary::whereMonth('month',$m)->whereYear('month',$year)->first();
            $allocationData['month'] = $month;
            $allocationData['salary_id'] = $allocation->id;
            $allocationData['user_id'] = auth()->user()->id;
            $allocationData['status'] = 'Pending';

            $allocations = array();
            foreach ($request->cost_center_id as  $key => $detail){
                $allocations [] =[
                    'cost_center_id'=>$request->cost_center_id[$key] ?? null,
                    'construction_head_office'=>$request->construction_head_office[$key] ?? null,
                    'icmd'=>$request->icmd[$key] ?? null,
                    'architecture'=>$request->architecture[$key] ?? null,
                    'supply_chain'=>$request->supply_chain[$key] ?? null,
                    'construction_project'=>$request->construction_project[$key] ?? null,
                    'contractual_salary'=>$request->contractual_salary[$key] ?? null,
                    'total_salary'=>$request->total_salary[$key] ?? null,
                ];
            }
            DB::transaction(function()use($request,$allocationData,$allocations){
                $allocation = SalaryAllocate::create($allocationData);
                $allocation->salaryAllocateDetails()->createMany($allocations);
            });
            return redirect()->route('salary-allocates.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalaryAllocate  $salaryAllocate
     * @return \Illuminate\Http\Response
     */
    public function show(SalaryAllocate $salaryAllocate)
    {
        //dd($salaryAllocate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalaryAllocate  $salaryAllocate
     * @return \Illuminate\Http\Response
     */
    public function edit(SalaryAllocate $salaryAllocate)
    {
        return view('accounts.salaryAllocates.create', compact('salaryAllocate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalaryAllocateRequest  $request
     * @param  \App\SalaryAllocate  $salaryAllocate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalaryAllocateRequest $request, SalaryAllocate $salaryAllocate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalaryAllocate  $salaryAllocate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaryAllocate $salaryAllocate)
    {
        try{
            $salaryAllocate->delete();
            return redirect()->route('salary-allocates.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){

        }
    }

    public function allocationApproval(SalaryAllocate $salaryAllocate)
    {
        try{
            $allocationStatus['status'] = 'Approved';

            $transectionData['voucher_type'] = 'Journal';
            $transectionData['transaction_date'] = now()->format('d-m-Y');
            $transectionData['user_id'] = auth()->user()->id;

            $creditAccount = Account::where('account_name', 'like', "%Salary & Allowances%")->where('balance_and_income_line_id',86)->first();
            $debitAccount = Account::where('account_name', 'like', "%Salary & Allowance -WIP%")->where('balance_and_income_line_id',14)->first();
            $debitPayableAccount = Account::where('account_name', 'like', "%Salary & Allowances Payable - WIP%")->where('balance_and_income_line_id',36)->first();
            $costCenter = CostCenter::where('name', 'like', "%Head Office%")->first();

            $ledgerCredit['account_id'] = $creditAccount->id;
            $ledgerCredit['cr_amount'] = $salaryAllocate->salaryAllocateDetails->flatten()->sum('total_salary') -
                                            $salaryAllocate->salaryAllocateDetails->flatten()->sum('construction_project')
                                - $salaryAllocate->salaryAllocateDetails->flatten()->sum('contractual_salary');
            $ledgerCredit['cost_center_id'] = $costCenter->id;

            DB::transaction(function()use($allocationStatus,$salaryAllocate,$transectionData, $debitAccount, $ledgerCredit, $debitPayableAccount){
                $transection = $salaryAllocate->transaction()->create($transectionData);

                foreach ($salaryAllocate->salaryAllocateDetails as $detailData){
                    $ledgerDebit['account_id'] = $debitAccount->id;
                    $ledgerDebit['dr_amount'] = $detailData->total_salary - $detailData->construction_project - $detailData->contractual_salary;
                    $ledgerDebit['cost_center_id'] = $detailData->cost_center_id;

                    $ledgerProject['account_id'] = $debitAccount->id;
                    $ledgerProject['dr_amount'] = $detailData->construction_project + $detailData->contractual_salary;
                    $ledgerProject['cost_center_id'] = $detailData->cost_center_id;
                    $ledgerProject['pourpose'] = 'Construction Project and Contractual Salary';

                    $ledgerPayableWip['account_id'] = $debitPayableAccount->id;
                    $ledgerPayableWip['cr_amount'] = $detailData->construction_project + $detailData->contractual_salary;
                    $ledgerPayableWip['cost_center_id'] = $detailData->cost_center_id;
                    $ledgerPayableWip['pourpose'] = 'Construction Project and Contractual Salary';

                    if ($detailData->total_salary > 0){
                        $transection->ledgerEntries()->create($ledgerDebit);
                        $transection->ledgerEntries()->create($ledgerProject);
                        $transection->ledgerEntries()->create($ledgerPayableWip);
                    }
                }

                $transection->ledgerEntries()->create($ledgerCredit);
                $salaryAllocate->update($allocationStatus);
            });
            return redirect()->route('salary-allocates.index')->with('message', 'Approved successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
