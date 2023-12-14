<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\Allocation;
use App\Accounts\Salary;
use App\Accounts\SalaryAllocate;
use App\CostCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAllocationRequest;
use App\Http\Requests\UpdateAllocationRequest;
use App\LedgerEntry;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AllocationController extends Controller
{

    public function index()
    {
        $allocations = Allocation::latest()->get();
        return view('accounts.allocations.index',compact('allocations'));
    }

    public function create()
    {
        return view('accounts.allocations.create');
    }

    public function store(StoreAllocationRequest $request)
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

            // dd(request()->all());
            $allocations = array();
            foreach ($request->cost_center_id as  $key => $detail){
                $allocations [] =[
                    'cost_center_id'=>$request->cost_center_id[$key] ?? null,
                    'management_fee'=>$request->management_fee[$key] ?? null,
                    'division_fee'=>$request->division_fee[$key] ?? null,
                    'construction_depreciation'=>$request->construction_depreciation[$key] ?? null,
                    'architecture_fee'=>$request->architectureFee[$key] ?? null,
                    'total_allocation'=>$request->total_allocation[$key] ?? null,
                ];
            }
            // dd($allocations);
            DB::transaction(function()use($request,$allocationData,$allocations){
                $allocation = Allocation::create($allocationData);
                $allocation->allocationDetails()->createMany($allocations);
            });
            return redirect()->route('allocations.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(Allocation $allocation)
    {
        //
    }

    public function edit(Allocation $id)
    {

    }

    public function update(UpdateAllocationRequest $request, Allocation $allocation)
    {
        //
    }

    public function destroy(Allocation $allocation)
    {
        //
    }

    public function allocationApproval(Allocation $allocation)
    {
        try{
            dd($allocation->allocationDetails);
            $allocationStatus['status'] = 'Approved';
            $transectionData['voucher_type'] = 'Journal';
            $transectionData['transaction_date'] = now()->format('d-m-Y');
            $transectionData['user_id'] = auth()->user()->id;

            $ArchitectureAccount = Account::where('account_name', 'like', "%Architecture Fee%")->where('balance_and_income_line_id',14)->first();
            $ArchitectureCreditAccount = Account::where('account_name', 'like', "%Inspace Architects Limited%")->where('balance_and_income_line_id',34)->first();
            $MDFeeAccount = Account::where('account_name', 'like', "%Division Fee%")->where('balance_and_income_line_id',14)->first();
            $MDFeeCreditAccount = Account::where('account_name', 'like', "%Rancon Holdings Ltd%")->where('balance_and_income_line_id',34)->first();
            $MFAccount = Account::where('account_name', 'like', "%Management Fee%")->where('balance_and_income_line_id',14)->first();


            DB::transaction(function()use($allocationStatus,$allocation,$transectionData, $ArchitectureAccount ,$ArchitectureCreditAccount ,$MDFeeAccount ,$MDFeeCreditAccount, $MFAccount){


                foreach ($allocation->allocationDetails as $detailData){

                    $ArcData['account_id'] = $ArchitectureAccount->id;
                    $ArcData['dr_amount'] = $detailData->architecture_fee ;
                    $ArcData['cost_center_id'] = $detailData->cost_center_id;
                    $ArcData['pourpose'] = Date('M-Y', strtotime($allocation->month));

                    $ArcCreditData['account_id'] = $ArchitectureCreditAccount->id;
                    $ArcCreditData['cr_amount'] = $detailData->architecture_fee ;
                    $ArcCreditData['cost_center_id'] = $detailData->cost_center_id;

                    $DFData['account_id'] = $MDFeeAccount->id;
                    $DFData['dr_amount'] = $detailData->division_fee ;
                    $DFData['cost_center_id'] = $detailData->cost_center_id;
                    $DFData['pourpose'] = Date('M-Y', strtotime($allocation->month));

                    $DFCreditData['account_id'] = $MDFeeCreditAccount->id;
                    $DFCreditData['cr_amount'] = $detailData->division_fee ;
                    $DFCreditData['cost_center_id'] = $detailData->cost_center_id;

                    $MFData['account_id'] = $MFAccount->id;
                    $MFData['dr_amount'] = $detailData->management_fee ;
                    $MFData['cost_center_id'] = $detailData->cost_center_id;
                    $MFData['pourpose'] = Date('M-Y', strtotime($allocation->month));

                    $CDData['account_id'] = $MFAccount->id;
                    $CDData['dr_amount'] = $detailData->management_fee ;
                    $CDData['cost_center_id'] = $detailData->cost_center_id;
                    $CDData['pourpose'] = Date('M-Y', strtotime($allocation->month));

                    $MFCreditData['account_id'] = $MDFeeCreditAccount->id;
                    $MFCreditData['cr_amount'] = $detailData->management_fee ;
                    $MFCreditData['cost_center_id'] = $detailData->cost_center_id;

                    if($detailData->architecture_fee > 0){
                        $transection = $allocation->transaction()->create($transectionData);
                        $transection->ledgerEntries()->create($ArcData);
                        $transection->ledgerEntries()->create($ArcCreditData);
                    }
                    if($detailData->division_fee > 0){
                        $transectionDF = $allocation->transaction()->create($transectionData);
                        $transectionDF->ledgerEntries()->create($DFData);
                        $transectionDF->ledgerEntries()->create($DFCreditData);
                    }

                    if($detailData->management_fee > 0){
                        $transectionCD = $allocation->transaction()->create($transectionData);
                        $transectionCD->ledgerEntries()->create($MFData);
                        $transectionCD->ledgerEntries()->create($MFCreditData);
                    }
                    if($detailData->construction_depreciation > 0){
                        $transectionMF = $allocation->transaction()->create($transectionData);
                        $transectionMF->ledgerEntries()->create($MFData);
                        $transectionMF->ledgerEntries()->create($MFCreditData);
                    }
                }

                Allocation::where('id',$allocation->id)->update($allocationStatus);
            });
            return redirect()->route('allocations.index')->with('message', 'Approved successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
