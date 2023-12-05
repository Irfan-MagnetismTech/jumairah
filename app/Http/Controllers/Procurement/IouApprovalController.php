<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Accounts\BankAccount;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Procurement\Iou;
use App\Procurement\IouReportMonthWise;
use App\Procurement\IouReportProjectWise;
use App\Procurement\Supplier;
use App\Transaction;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IouApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( )
    {
    }
    public function iouapprovalview(Iou $iou)
    {
//        dd($iou);
        $data['status'] = '';
        $iou->update($data);

        return view('procurement.ious.iouapprovals', compact('iou'));
//        if ($iou->status == 'Accepted'){
//        }else{
//            return redirect()->route('ious.index')->with('message', "This IOU  $status  Successfully");
//        }
    }

    public function store(Request $request )
    {
        try{
            $iouData = Iou::where('id',$request->iou_id)->first();

                $to_days_date = $this->formatDate($iouData->created_at);
                $cost_center_short_name = $iouData->costCenter->shortName;
                $is_exist_projectwise_iou_date = IouReportProjectWise::query()->where('cost_center_id', $iouData->cost_center_id)
                    ->where('iou_date', $to_days_date)->first();

                $projectWiseData = IouReportProjectWise::updateOrCreate(
                    [
                        'cost_center_id' => $iouData->cost_center_id,
                        'iou_date' => $to_days_date
                    ],
                    [
                        'cost_center_id' => $iouData->cost_center_id,
                        'iou_date' => $to_days_date,
                        'project_wise_iou' => $is_exist_projectwise_iou_date ? $is_exist_projectwise_iou_date->project_wise_iou + 1 : 1
                    ]
                );

                $is_exist_monthWise_iou_date = IouReportMonthWise::query()->where('date', $to_days_date)->first();
                $monthWiseData = IouReportMonthWise::updateOrCreate(
                    [
                        'date' => $to_days_date,
                    ],
                    [
                        'date' => $to_days_date,
                        'month_wise_iou' => $is_exist_monthWise_iou_date ? $is_exist_monthWise_iou_date->month_wise_iou + 1 : 1,
                    ]
                );
                $iou_no['iou_no'] = $to_days_date . "-" . $cost_center_short_name . $projectWiseData['project_wise_iou'] . "-IOU-" . $monthWiseData['month_wise_iou'];
                $iou_no['status'] = 'Accepted';
                $iouData->update($iou_no);

            $costCenter  = $iouData->costCenter->id;
            $transection['voucher_type'] = 'Payment';
            $transection['transaction_date'] = date('d-m-Y', strtotime(now()));
            $transection['narration'] = $request->narration;
            $transection['user_id'] = auth()->user()->id;
            $transection['cheque_type'] = $request->payment_mode;
            $transection['cheque_date'] = $request->cheque_date;
            $transection['cheque_number'] = $request->cheque_number;
            $data['status'] = 'Accepted';

            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($iouData) {
                $q->where([['name','IOU'],['department_id',$iouData->appliedBy->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($iouData){
                $q->where('approvable_id',$iouData->id)
                    ->where('approvable_type',Iou::class);
            })->orderBy('order_by','asc') ->first();

            // $approveData = [
            //     'layer_key' => $approval->layer_key,
            //     'user_id' => auth()->id(),
            //     'status' => 1,
            // ];

            if ($request->payment_mode == 'Cash'){
                $accountCash = Account::where('balance_and_income_line_id', 7)->where('account_name','like','%Cash in Hand%')->first();
                $account = $accountCash->id;
            }else{
                $account = $request->bank_account_id;
            }

            $creditLedger['account_id'] = $account;
            $creditLedger['cr_amount'] = $iouData->total_amount;
            $creditLedger['cost_center_id'] = $costCenter;

            $debitLedger['dr_amount'] = $iouData->total_amount;
            $debitLedger['cost_center_id'] = $costCenter;
            $debitLedger['pourpose'] = 'Advanced';

            DB::transaction(function()use($data,$iouData, $transection,$creditLedger, $debitLedger){
                // $approvalData = $iouData->approval()->create($approveData);
                $iouData->update($data);
                if (!empty($iouData->supplier_id)){
                    $debitAccount = Account::where('balance_and_income_line_id',34)->where('accountable_type',Supplier::class)
                        ->where('accountable_id',$iouData->supplier_id)->first();
                }else{
                    $accountData['account_name']= 'Advance - ' . $iouData->appliedBy->name ;
                    $accountData['account_type']= 1;
                    $accountData['account_code']= "1-5-9-".$iouData->applied_by;
                    $accountData['balance_and_income_line_id']= 9;
                    $debitAccount = $iouData->appliedBy->account()->updateOrCreate(['accountable_type'=>User::class,'accountable_id'=>$iouData->applied_by],$accountData);
                }

                // dd($transection);
                $transectionData = $iouData->transaction()->create($transection);
                $debitLedger['account_id'] = $debitAccount->id;
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
            });
            return redirect()->route('ious.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    private function formatDate(string $date): string
    {
        return substr( date_format(date_create($date),"m-y"), 0);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
