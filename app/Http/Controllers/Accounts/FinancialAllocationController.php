<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\FinancialAllocation ;
use App\Approval\ApprovalLayerDetails;
use App\CostCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancialAllocationRequest;
use App\Http\Requests\UpdateFinancialAllocationRequest;
use App\LedgerEntry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FinancialAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allocations = FinancialAllocation::with('financialAllocationDetails')->latest()->get();
        return view('accounts.financial-allocations.index',compact('allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('accounts.financial-allocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFinancialAllocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFinancialAllocationRequest $request)
    {
        try{
            $from_month = $request->from_month.'-01';
            $to_month = $request->to_month.'-01';
            // $from_m = date('m', strtotime($from_month));
            // $from_year = date('Y', strtotime($from_month));
            // $allocation = Salary::whereMonth('month',$m)->whereYear('month',$year)->first();
            $allocationData = $request->only('sod_amount', 'hbl_amount');
            $allocationData['from_month'] = $from_month;
            $allocationData['to_month'] = $to_month;
            $allocationData['user_id'] = auth()->user()->id;
            // $allocationData['status'] = 'Pending';

            // dd(request()->all());
            $allocations = array();
            foreach ($request->cost_center_id as  $key => $detail){
                $allocations [] =[
                    'cost_center_id'=>$request->cost_center_id[$key] ?? null,
                    'sod_allocate_amount'=>$request->sod_allocate[$key] ?? null,
                    'hbl_allocate_amount'=>$request->hbl_allocate[$key] ?? null,
                    'total_allocation'=>$request->total_allocation[$key] ?? null,
                ];
            }
            // dd($allocationData, $allocations);
            DB::transaction(function()use($request,$allocationData,$allocations){
                $allocation = FinancialAllocation::create($allocationData);
                $allocation->financialAllocationDetails()->createMany($allocations);
            });
            return redirect()->route('financial-allocations.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FinancialAllocation  $financialAllocation
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialAllocation $financialAllocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FinancialAllocation  $financialAllocation
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialAllocation $financialAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFinancialAllocationRequest  $request
     * @param  \App\FinancialAllocation  $financialAllocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFinancialAllocationRequest $request, FinancialAllocation $financialAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FinancialAllocation  $financialAllocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialAllocation $financialAllocation)
    {
        //
    }

    public function financialAllocationApproval(FinancialAllocation $financialAllocation, $status){
        try{
            $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Supplier Bill');
            })->wheredoesnthave('approvals',function ($q) use($financialAllocation){
                $q->where('approvable_id',$financialAllocation->id)->where('approvable_type',FinancialAllocation::class);
            })->orderBy('order_by','asc')->first();

            $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Supplier Bill');
            })->wheredoesnthave('approvals',function ($q) use($financialAllocation){
                $q->where('approvable_id',$financialAllocation->id)->where('approvable_type',FinancialAllocation::class);
            })->orderBy('order_by','desc')->first();

            $data = [
                'layer_key' => $approvalfirst->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            $m = date('m',strtotime($financialAllocation->from_month.'-01'));
            $year = date('Y',strtotime($financialAllocation->from_month.'-01'));

            $fromDate = $year.'-'.$m.'-01';
            $toDate =  date("Y-m-t", strtotime($financialAllocation->to_month));

            $ho = CostCenter::where('name','like',"%Head Office%")->first();
            $hblLoans = LedgerEntry::with('account')
                ->whereHas('account', function ($q){
                    $q->where('balance_and_income_line_id',87)->where('loan_type','HBL');
                })
                ->whereHas('transaction', function ($q) use ($fromDate, $toDate){
                    $q->whereBetween('transaction_date',["$fromDate","$toDate"]);
                })
                ->where('cost_center_id',$ho->id)
                ->get()->groupBy('account_id');

            $sodLoans = LedgerEntry::with('account')
                ->whereHas('account', function ($q){
                    $q->where('balance_and_income_line_id',87)->where('loan_type','SOD');
                })
                ->whereHas('transaction', function ($q) use ($fromDate, $toDate){
                    $q->whereBetween('transaction_date',["$fromDate","$toDate"]);
                })
                ->where('cost_center_id',$ho->id)
                ->get()->groupBy('account_id');

            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = date('d-m-Y', strtotime(now()));
            $transection['user_id'] = auth()->user()->id;

            DB::transaction(function()use($data,$financialAllocation,$approvallast, $hblLoans, $sodLoans, $transection){
                 $approvalData  = $financialAllocation->approval()->create($data);
                 if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
                $transectionData = $financialAllocation->transaction()->create($transection);
                foreach ($hblLoans as $key => $hblLoan){
                    $hblAmount = $hblLoan->flatten()->sum('dr_amount');
                    // if($hblAmount > 0){
                    $hblCrData = [
                        'account_id' => $key,
                        'cost_center_id' => $hblLoan[0]->cost_center_id,
                        'cr_amount' => $hblAmount,
                    ];
                    $transectionData->ledgerEntries()->create($hblCrData);
                    // }
                }
                foreach ($sodLoans as $skey => $sodLoan){
                    $sodAmount = $sodLoan->flatten()->sum('dr_amount');
                    // if($sodAmount > 0){
                    $sodCrData = [
                        'account_id' => $skey,
                        'cost_center_id' => $sodLoan[0]->cost_center_id,
                        'cr_amount' => $sodAmount,
                    ];
                    $transectionData->ledgerEntries()->create($sodCrData);
                    // }
                }
                $account = Account::where('balance_and_income_line_id',14)->where('parent_account_id',142)
                    ->where('account_name', 'like', '%Bank Interest - WIP%')->first();
                    foreach($financialAllocation->financialAllocationDetails as $detail){
                        if($detail->hbl_allocate_amount > 0){
                            $hblAllocats = [
                                'account_id' => $account->id,
                                'cost_center_id' => $detail->cost_center_id,
                                'dr_amount' => $detail->hbl_allocate_amount,
                            ];
                            $transectionData->ledgerEntries()->create($hblAllocats);
                        }
                        if($detail->sod_allocate_amount > 0){
                            $sodAllocats = [
                                'account_id' => $account->id,
                                'cost_center_id' => $detail->cost_center_id,
                                'dr_amount' => $detail->sod_allocate_amount,
                            ];
                            $transectionData->ledgerEntries()->create($sodAllocats);
                        }
                    }
                 }
            });
            return redirect()->route('financial-allocations.index')->with('message', 'Approved successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }
}
