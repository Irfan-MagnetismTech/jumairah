<?php

namespace App\Http\Controllers\Sells;

use App\Accounts\Account;
use App\Accounts\BankAccount;
use App\Bank;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesCollectionApprovalRequest;
use App\Sale;
use App\SalesCollection;
use App\SalesCollectionDetails;
use App\Sells\InstallmentList;
use App\Sells\SalesCollectionApproval;
use App\Sells\Sell;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesCollectionApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales_collection_approvals = SalesCollectionApproval::with('salecollection')->latest()->get();
        return view('sales.salesCollectionApprovals.index', compact('sales_collection_approvals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }
    public function addsalescollectionapproval($salesCollection_id)
    {
        $banks = BankAccount::orderBy('name')->pluck('name', 'id');
        $bills = Transaction::whereNotNull('bill_no')->pluck('bill_no', 'bill_no');
        $approval_status = ['Honored' => 'Honored', 'Hold' => 'Hold', 'Dishonored' => 'Dishonored', 'Canceled' => 'Canceled'];
        $saleCollection = SalesCollection::with('salesCollectionDetails', 'sell',  'sell.apartment.project')->where('id', $salesCollection_id)->firstOrFail();
        // dd($saleCollection->salesCollectionDetails);
        return view('sales.salesCollectionApprovals.create', compact('banks', 'bills', 'saleCollection', 'approval_status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesCollectionApprovalRequest $request)
    {
        try {
            //            dd($request->all());
            $salesCollectionApprovalData = $request->only(
                'salecollection_id',
                'approval_status',
                'approval_date',
                'reason',
                'bank_account_id',
                'sundry_creditor_account_id',
                'bank_date'
            );
            DB::transaction(function () use ($request, $salesCollectionApprovalData) {
                $salesCollectionApproval = SalesCollectionApproval::create($salesCollectionApprovalData);
                if ($request->approval_status == "Honored") {
                    $saleCollection = SalesCollection::with('sell', 'salesCollectionDetails')->whereId($request->salecollection_id)->first();
                    $rebateChargePerDay = $saleCollection->sell->apartment->project->rebateChargePerDay;
                    $delayCharge = $saleCollection->sell->apartment->project->DelayChargePerDay;
                    $received_date = Carbon::parse($request->approval_date);

                    $accountDebit = $saleCollection->sell->account->id;
                    $costCenterId = $saleCollection->sell->apartment->project->costCenter->id;

                    $accountCredit = Account::where('accountable_type', BankAccount::class)->where('accountable_id', $request->bank_account_id)->first('id');

                    $transection['voucher_type'] = $saleCollection->payment_mode == 'Adjustment' ? 'Journal' : 'Receipt';
                    $transection['transaction_date'] = $request->approval_date;
                    $transection['mr_no'] = $saleCollection->id;
                    $transection['cheque_type'] = $saleCollection->payment_mode;
                    $transection['cheque_number'] = $saleCollection->transaction_no;
                    $transection['cheque_date'] = $salesCollectionApproval->approval_date;
                    $transection['narration'] = $salesCollectionApproval->reason;
                    $transection['user_id'] = auth()->user()->id;

                    $transectionData = $salesCollectionApproval->salecollection->transaction()->create($transection);

                    $collectionDetailData = array();
                    $LedgerData = array();
                    $accountName = $saleCollection->sell->sellClients->first()->client->name . ' - ' . request()->project_name . ' - ' . $saleCollection->sell->apartment->name;
                    $totalDrAmount = 0;
                    foreach ($saleCollection->salesCollectionDetails as $key => $salesCollectionDetail) {
                        $accountInstallment = Account::where('accountable_type', Sell::class)->where('accountable_id', $saleCollection->sell_id)->first();

                        if ($salesCollectionDetail->particular == "Installment") {
                            $installmentInfo = InstallmentList::whereInstallmentNo($salesCollectionDetail->installment_no)->whereHas('sell', function ($q) use ($saleCollection) {
                                $q->whereId($saleCollection->sell_id);
                            })->first();
                            $scheduled_date = Carbon::parse($installmentInfo->installment_date);
                            $delayDays = $scheduled_date->diffInDays($received_date, false);
                            if ($delayDays > 0) {
                                $appliedAmount = ($salesCollectionDetail->amount / 100 * $delayCharge) * $delayDays;
                            } else {
                                $appliedAmount = ($salesCollectionDetail->amount / 100 * $rebateChargePerDay) * $delayDays;
                            }
                            $salesCollectionDetail->update([
                                'applied_days' => $delayDays ?? null,
                                'applied_amount' => $appliedAmount ?? 0,
                            ]);
                            $accountInstallmentData['account_id'] = $accountInstallment->id;
                            $accountInstallmentData['cr_amount'] = $salesCollectionDetail->amount;
                            $accountInstallmentData['cost_center_id'] = $costCenterId;
                            $accountInstallmentData['pourpose'] = 'Installment - ' . $salesCollectionDetail->installment_no;
                            $transectionData->ledgerEntries()->create($accountInstallmentData);
                        }
                        if ($salesCollectionDetail->particular == 'Booking Money') {
                            $ledgerBMData['account_id'] = $accountInstallment->id;
                            $ledgerBMData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerBMData['cost_center_id'] = $costCenterId;
                            $ledgerBMData['pourpose'] = 'Booking Money';
                            $transectionData->ledgerEntries()->create($ledgerBMData);
                        }
                        if ($salesCollectionDetail->particular == 'Down Payment') {
                            $ledgerBMData['account_id'] = $accountInstallment->id;
                            $ledgerBMData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerBMData['cost_center_id'] = $costCenterId;
                            $ledgerBMData['pourpose'] = 'Down Payment';
                            $transectionData->ledgerEntries()->create($ledgerBMData);
                        }
                        if ($salesCollectionDetail->particular == 'Registration Charge') {
                            $regAccount = Account::where('balance_and_income_line_id', 37)->where('account_name', 'like', "%Registration Charge%")->first();
                            $regLedgerData['account_id'] = $regAccount->id;
                            $regLedgerData['cr_amount'] = $salesCollectionDetail->amount;
                            $regLedgerData['cost_center_id'] = $costCenterId;
                            $regLedgerData['pourpose'] = "$accountName";
                            $transectionData->ledgerEntries()->create($regLedgerData);
                        }
                        if ($salesCollectionDetail->particular == 'Delay Charge') {
                            $parentAccount = Account::where('balance_and_income_line_id', 35)->where('account_name', 'like', 'Delay Charge')->first();
                            $delayChargeAccount['account_name'] = 'DC - ' . $accountName;
                            $delayChargeAccount['account_type'] = 2;
                            $delayChargeAccount['account_code'] = "26-33-35-" . $salesCollectionDetail->sales_collection_id;
                            $delayChargeAccount['balance_and_income_line_id'] = 35;
                            $delayChargeAccount['parent_account_id'] = $parentAccount->id;

                            $saleCollection->account()->firstOrCreate(
                                $delayChargeAccount
                            );
                            $accountDC = Account::where('account_name', 'like', "%$accountName%")->where('parent_account_id', $parentAccount->id)->first();
                            $ledgerDcData['account_id'] = $accountDC->id;
                            $ledgerDcData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerDcData['cost_center_id'] = $costCenterId;

                            $transectionData->ledgerEntries()->create($ledgerDcData);
                        }
                        if ($salesCollectionDetail->particular == 'Modification Cost') {

                            $MCParentAccount = Account::where('balance_and_income_line_id', 35)->where('account_name', 'like', 'Modification Cost')->first();
                            $MCAccount['account_name'] = 'MC - ' . $accountName;
                            $MCAccount['account_type'] = 2;
                            $MCAccount['account_code'] = "26-33-35-" . $salesCollectionDetail->sell_id;
                            $MCAccount['balance_and_income_line_id'] = 35;
                            $MCAccount['parent_account_id'] = $MCParentAccount->id;

                            $saleCollection->account()->firstOrCreate(
                                //                                ['accountable_type'=>SalesCollection::class,'accountable_id'=>$saleCollection->id],
                                $MCAccount
                            );

                            $accountMC = Account::where('account_name', 'like', "%$accountName%")->where('parent_account_id', $MCParentAccount->id)->first();
                            $ledgerMcData['account_id'] = $accountMC->id;
                            $ledgerMcData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerMcData['cost_center_id'] = $costCenterId;
                            $transectionData->ledgerEntries()->create($ledgerMcData);
                        }
                        if ($salesCollectionDetail->particular == 'Size Increased Cost') {
                            //                            $accountSIC = Account::where('account_name','Size Increased Cost')->first();
                            $ledgerSICData['account_id'] = $accountInstallment->id;
                            $ledgerSICData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerSICData['cost_center_id'] = $costCenterId;
                            $ledgerSICData['pourpose'] = 'Size Increased Cost';
                            $transectionData->ledgerEntries()->create($ledgerSICData);
                        }
                        if ($salesCollectionDetail->particular == 'Service Charge') {
                            $accountSC = Account::where('balance_and_income_line_id', 109)->where('account_name', 'like', "%Service Charge%")->first();
                            $ledgerSCData['account_id'] = $accountSC->id;
                            $ledgerSCData['cr_amount'] = $salesCollectionDetail->amount;
                            $ledgerSCData['cost_center_id'] = $costCenterId;
                            $transectionData->ledgerEntries()->create($ledgerSCData);
                        }
                        $totalDrAmount += $salesCollectionDetail->amount;
                    }
                    //                dd($request->all());
                    $BillArray = [];
                    $supplierLedger = [];
                    if ($saleCollection->payment_mode == 'Adjustment') {
                        foreach ($request->bill_no as $key => $bill) {
                            $supplierLedger[] = [
                                'account_id' => $request->sundry_creditor_account_id,
                                'amount' => str_replace(',', '', $request->bill_amount[$key]),
                                'ref_bill' => $request->bill_no[$key],
                                'cost_center_id' => $costCenterId,
                            ];
                        }
                        //                        dd($supplierLedger);
                        $transectionData->paidBillTransections()->createMany($supplierLedger);
                        $creditorsAccount =  $request->sundry_creditor_account_id;
                    } else {
                        $creditorsAccount = $request->bank_account_id;
                    }

                    if (!empty($request->bank_account_id)) {
                        $bankReconcilation['transaction_date'] = $request->approval_date;
                        $bankReconcilation['user_id'] = auth()->user()->id;
                        $bankReconcilation['status'] = 'Complete';
                        $transectionData->bankReconciliation()->create($bankReconcilation);
                    }
                    $bankLedger['account_id'] = $creditorsAccount;
                    $bankLedger['dr_amount'] = $totalDrAmount;
                    $bankLedger['cost_center_id'] = $costCenterId;
                    $bankLedger['remarks'] = '';
                    $transectionData->ledgerEntries()->create($bankLedger);
                }
            });

            return redirect()->route('salesCollections.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesCollectionApproval  $salesCollectionApproval
     * @return \Illuminate\Http\Response
     */
    public function show(SalesCollectionApproval $salesCollectionApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesCollectionApproval  $salesCollectionApproval
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesCollectionApproval $salesCollectionApproval)
    {
        $approval_status = ['Honored' => 'Honored', 'Hold' => 'Hold', 'Dishonored' => 'Dishonored', 'Canceled' => 'Canceled'];
        $saleCollection = SalesCollection::where('id', $salesCollectionApproval->salecollection->id)->firstOrFail();
        return view('sales.salesCollectionApprovals.create', compact('saleCollection', 'salesCollectionApproval', 'approval_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesCollectionApproval  $salesCollectionApproval
     * @return \Illuminate\Http\Response
     */
    public function update(SalesCollectionApprovalRequest $request, SalesCollectionApproval $salesCollectionApproval)
    {
        try {
            $salesCollectionApprovalData = $request->only(
                'salecollection_id',
                'approval_status',
                'approval_date',
                'reason',
                'bank_account_id',
                'sundry_creditor_account_id'
            );

            if ($request->approval_status == "Honored") {
                $saleCollection = SalesCollection::with('sell', 'salesCollectionDetails')->whereId($request->salecollection_id)->first();
                $rebateChargePerDay = $saleCollection->sell->apartment->project->rebateChargePerDay;
                $delayCharge = $saleCollection->sell->apartment->project->DelayChargePerDay;
                $received_date = Carbon::parse($request->approval_date);

                $collectionDetailData = array();
                foreach ($saleCollection->salesCollectionDetails as  $key => $salesCollectionDetail) {
                    if ($salesCollectionDetail->particular == "Installment") {
                        $installmentInfo = InstallmentList::whereInstallmentNo($salesCollectionDetail->installment_no)->whereHas('sell', function ($q) use ($saleCollection) {
                            $q->whereId($saleCollection->sell_id);
                        })->first();
                        $scheduled_date = Carbon::parse($installmentInfo->installment_date);
                        $delayDays = $scheduled_date->diffInDays($received_date, false);
                        if ($delayDays > 0) {
                            $appliedAmount = ($salesCollectionDetail->amount / 100 * $delayCharge) * $delayDays;
                        } else {
                            $appliedAmount = ($salesCollectionDetail->amount / 100 * $rebateChargePerDay) * $delayDays;
                        }
                        $salesCollectionDetail->update([
                            'applied_days' => $delayDays ?? null,
                            'applied_amount' => $appliedAmount ?? null,
                        ]);
                    }
                    //                dd($collectionDetailData);
                }
            } else {
                $saleCollection = SalesCollection::with('sell', 'salesCollectionDetails')->whereId($request->salecollection_id)->first();
                $rebateChargePerDay = $saleCollection->sell->apartment->project->rebateChargePerDay;
                $delayCharge = $saleCollection->sell->apartment->project->DelayChargePerDay;
                $received_date = Carbon::parse($request->approval_date);

                $collectionDetailData = array();
                foreach ($saleCollection->salesCollectionDetails as  $key => $salesCollectionDetail) {
                    if ($salesCollectionDetail->particular == "Installment") {
                        $installmentInfo = InstallmentList::whereInstallmentNo($salesCollectionDetail->installment_no)->whereHas('sell', function ($q) use ($saleCollection) {
                            $q->whereId($saleCollection->sell_id);
                        })->first();
                        $scheduled_date = Carbon::parse($installmentInfo->installment_date);
                        $delayDays = $scheduled_date->diffInDays($received_date, false);
                        $salesCollectionDetail->update([
                            'applied_days' => 0,
                            'applied_amount' => 0,
                        ]);
                    }
                    //                dd($collectionDetailData);
                }
            }

            $salesCollectionApproval->update($salesCollectionApprovalData);
            return redirect()->route('salesCollections.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesCollectionApproval  $salesCollectionApproval
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesCollectionApproval $salesCollectionApproval)
    {
        try {
            foreach ($salesCollectionApproval->salecollection->salesCollectionDetails as  $key => $salesCollectionDetail) {
                if ($salesCollectionDetail->particular == "Installment") {
                    $salesCollectionDetail->update([
                        'applied_days' => null,
                        'applied_amount' => null,
                    ]);
                }
            }
            $salesCollectionApproval->delete();
            return redirect()->route('salesCollectionApprovals.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
