<?php

namespace App\Http\Controllers\Sells;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleCancellationApprovalRequest;
use App\Http\Requests\SaleCancellationRequest;
use App\Procurement\Requisition;
use App\Procurement\Requisitiondetails;
use App\Sells\SaleCancellation;
use App\Sells\Sell;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SaleCancellationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleCancellations = SaleCancellation::latest()->get();
        return view('sales.saleCancellations.index', compact('saleCancellations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType='create';
        $clients = [];
        return view('sales.saleCancellations.create', compact('formType', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleCancellationRequest $request)
    {
        try{
            $cancellationData = $request->only('sell_id','paid_amount','service_charge','deducted_amount','refund_amount','remarks','applied_date','cancelled_by');
            $cancellationData['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('saleCancellation') : null;
            $cancellationData['entry_by'] = auth()->id();
            $cancellationData['status'] = "Pending";
            SaleCancellation::create($cancellationData);
            return redirect()->route('saleCancellations.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SaleCancellation  $saleCancellation
     * @return \Illuminate\Http\Response
     */
    public function show(SaleCancellation $saleCancellation)
    {
        // $salesCollection = SalesCollection::with('salesCollectionDetails', 'sell.sellClient.client',  'sell.apartment.project')->where('id', $salesCollection->id)->firstOrFail();
        return view('sales.saleCancellations.show', compact('saleCancellation'));

        dd($saleCancellation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SaleCancellation  $saleCancellation
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleCancellation $saleCancellation)
    {
        $formType='edit';
        $clients = [];
        return view('sales.saleCancellations.create', compact('formType', 'clients', 'saleCancellation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleCancellation  $saleCancellation
     * @return \Illuminate\Http\Response
     */
    public function update(SaleCancellationRequest $request, SaleCancellation $saleCancellation)
    {
        try{
            $cancellationData = $request->only('sell_id','paid_amount','service_charge','deducted_amount','refund_amount','remarks','applied_date','cancelled_by');
            $cancellationData['status'] = "Pending";
            if($request->hasFile('attachment')){
                file_exists(asset($saleCancellation->attachment)) && $saleCancellation->attachment ? unlink($saleCancellation->attachment) : null;
                $cancellationData['attachment'] = $request->hasFile('attachment') ? $request->file('attachment')->store('saleCancellation') : null;
            }
            $saleCancellation->update($cancellationData);
            return redirect()->route('saleCancellations.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleCancellation  $saleCancellation
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleCancellation $saleCancellation)
    {
        try{
            $saleCancellation->delete();
            return redirect()->route('saleCancellations.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function approveSaleCancellation($saleCancellationId)
    {
        $saleCancellation = SaleCancellation::where('id', $saleCancellationId)->firstOrFail();
        return view('sales.saleCancellations.approve', compact('saleCancellation'));
    }

    public function storeApprovalInformation(SaleCancellationApprovalRequest $request){
        try{
            $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Sale Cancellation');
            })->wheredoesnthave('approvals',function ($q) use($request){
                $q->where('approvable_id',$request->sale_cancellation_id)->where('approvable_type',SaleCancellation::class);
            })->orderBy('order_by','asc')->first();

            $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Sale Cancellation');
            })->wheredoesnthave('approvals',function ($q) use($request){
                $q->where('approvable_id',$request->sale_cancellation_id)->where('approvable_type',SaleCancellation::class);
            })->orderBy('order_by','desc')->first();

            $data = [
                'layer_key' => $approvalfirst->layer_key,
                'user_id' => auth()->id(),
                'status' => $request->status,
            ];

            $approvedData = $request->only('approved_charge', 'approved_deducted_amount', 'refund_amount');
            $approvedData['approved_date'] = Carbon::now()->format('d-m-Y');
            $approvedData['approved_by'] = auth()->id();
            $approvedData['status'] = $request->status;

            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = Carbon::now()->format('d-m-Y');
            $transection['user_id'] = auth()->user()->id;

            DB::transaction(function()use($request, $approvedData, $transection, $data,$approvallast) {
                SaleCancellation::where('id', $request->sale_cancellation_id)->first()->update($approvedData);
                $saleCancel = SaleCancellation::where('id', $request->sale_cancellation_id)->first();
                $approvalData  = $saleCancel->approval()->create($data);

                $proiject_id = $saleCancel->sell->apartment->project->costCenter->id;
                $accountData['account_name']= 'Refund - ' . $saleCancel->sell->sellClients->first()->client->name.' - '. $request->project_name.' - '.$saleCancel->sell->apartment->name;
                $accountData['account_code']= "26-33-107-".$saleCancel->sell->id;
                $accountData['account_type']= 2;
                $accountData['balance_and_income_line_id']= 107;
                $account = $saleCancel->account()->updateOrCreate(
                    ['accountable_type'=>SaleCancellation::class,'accountable_id'=>$saleCancel->id],
                    $accountData
                );

                $debitAccount = Account::where('balance_and_income_line_id', 35)->where('accountable_type', Sell::class)->where('accountable_id',$saleCancel->sell->id)->first();
                $debitLedger['account_id'] = $debitAccount->id;
                $debitLedger['dr_amount'] = $request->paid_amount;
                $debitLedger['cost_center_id'] = $proiject_id;

                $creditLedger['account_id'] = $account->id;
                $creditLedger['cr_amount'] = $request->paid_amount - $request->approved_deducted_amount;
                $creditLedger['cost_center_id'] = $proiject_id;

                $deductAccount = Account::where('balance_and_income_line_id', 108)->where('account_name','like',"%Miscellaneous%")->first();
                $deductLedger['account_id'] = $deductAccount->id;
                $deductLedger['cr_amount'] = $request->approved_deducted_amount;
                $deductLedger['pourpose'] = 'Deduction';
                $deductLedger['cost_center_id'] = $proiject_id;

//                dd($debitLedger, $creditLedger, $deductLedger);
                if ($approvalData->layer_key == $approvallast->layer_key && $approvalData->status == 'Approved') {
                    $transectionData = $saleCancel->transaction()->create($transection);
                    $transectionData->ledgerEntries()->create($debitLedger);
                    $transectionData->ledgerEntries()->create($creditLedger);
                    $transectionData->ledgerEntries()->create($deductLedger);
                }

            });
            return redirect()->route('saleCancellations.index')->with('message', 'Request has been approved.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

}
