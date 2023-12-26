<?php

namespace App\Http\Controllers\Sells;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\Accounts\BankAccount;
use App\Http\Controllers\BalanceAndIncomeLineController;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Sells\ApartmentHandover;
use App\Sells\Sell;
use App\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ApartmentHandoverController extends Controller
{
    const PERMISSIONS = [
        'Pending' => ['authority', 'ceo'],
        'Approved' => ['audit'],
        'Checked' => ['accountant']
    ];

    const STATUS = [
        'Pending' => 'Approved',
        'Approved' => 'Checked',
        'Checked' => 'Complete'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function handover($sell_id)
    {
        $formType = 'create';
        $sell = Sell::with('salesCollections.salesCollectionDetails', 'installmentList', 'apartment.project', 'sellClients.client')->where('id', $sell_id)->firstOrFail();
        return view('sales/apartment-handovers.create', compact('sell', 'formType'));
    }


    public function index()
    {
        $sells = Sell::with('salesCollections.salesCollectionDetails', 'installmentList', 'apartment.project',
            'sellClients.client')->whereHas('handover')
            ->orderBy('id')->get();
        return view('sales/apartment-handovers.index', compact('sells'));
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

    public function store(Request $request)
    {
        try{
            ApartmentHandover::create($request->only('sell_id', 'handover_date','remarks'));
            return redirect()->route('apartment-handovers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sells\ApartmentHandover  $apartmentHandover
     * @return \Illuminate\Http\Response
     */
    public function show(ApartmentHandover $apartmentHandover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sells\ApartmentHandover  $apartmentHandover
     * @return \Illuminate\Http\Response
     */
    public function edit(ApartmentHandover $apartmentHandover)
    {
        // dd($apartmentHandover);
        $formType = 'edit';
        $sell = Sell::with('salesCollections.salesCollectionDetails', 'installmentList', 'apartment.project', 'sellClients.client', 'handover')
        ->whereHas('handover', function($q)use($apartmentHandover){
            $q->where('id',$apartmentHandover->id);
        })
        ->firstOrFail();
        // dd($sell);
        return view('sales/apartment-handovers.create', compact('sell', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sells\ApartmentHandover  $apartmentHandover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApartmentHandover $apartmentHandover)
    {
        try{
            $apartmentHandover->update($request->only('sell_id', 'handover_date','remarks'));
            return redirect()->route('apartment-handovers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sells\ApartmentHandover  $apartmentHandover
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApartmentHandover $apartmentHandover)
    {
        try{
            // dd($apartmentHandover->transaction()->exists());
            if($apartmentHandover->transaction()->exists()){
                return back()->withErrors(["This Apartment has some Transections. Please Delete them first"]);
            }
            else{ 
                $apartmentHandover->delete();
            }

            return redirect()->route('apartment-handovers.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function apartmentHandoverApproval(Request $request)
    {
        // Status = Pending / Approved / Checked / Complete
//        $apartmentHandover = ApartmentHandover::where('id', 6);
        $apartmentHandover = ApartmentHandover::where('id', $request->handover_id);
        $handover = $apartmentHandover->first();
        $status = $handover->status;

        $projectName = $handover->sell->apartment->project->name;
        $balanceLine = BalanceAndIncomeLine::where('parent_id',75)->where('line_text', 'like',"%$projectName%")->first();

        if(auth()->user()->hasAnyRole(['super-admin', 'admin', ...self::PERMISSIONS[$status]]))
        {
            $apartmentHandover->update(['status' => self::STATUS[$status], 'authority_id' => auth()->id()]);
            if(self::STATUS[$status] == "Complete"){
                $costCenterId = $handover->sell->apartment->project->costCenter->id;
                $projectCosts  = Account::
                    wherehas('ledgers', function ($q) use ($handover,$costCenterId) {
                        $q->where('cost_center_id', $costCenterId);
                    })
                    ->with(['ledgers' => function ($q) use ($handover,$costCenterId) {
                        $q->where('cost_center_id', $costCenterId);
                    }])->where('balance_and_income_line_id' ,14)->get();

                $projectArea = $handover->sell->apartment->project->sellable_area;
                $apartmentArea = $handover->sell->apartment->apartment_size;
                    $costGroups = $projectCosts->groupBy('group');
                    $cogsArray = array();
                    foreach ($costGroups as $key => $costGroupData){
                        $cogsProjectSqrCost = $costGroupData->pluck('ledgers')->flatten()->sum('dr_amount')/ $projectArea;
                        $cogsApartmentSqrCost = $cogsProjectSqrCost * $apartmentArea;

                        $parentGroup = $costGroupData->first();
                        $cogsAccount = Account::where('balance_and_income_line_id',$balanceLine->id)
                                        ->where('group',$parentGroup->group)
                                        ->first();

                        $cogsArray [] = [
                            'account_id' => $cogsAccount->id,
                            'dr_amount' => number_format($cogsApartmentSqrCost, 2),
                            'cost_center_id' => $costCenterId,
                        ];
                    }
                $costDataArray = array();
                foreach ($projectCosts as $projectCost){
                    $materialCost = $projectCost->ledgers->sum('dr_amount');
                    $perSqrCost = $materialCost / $projectArea;
                    $perApartmentCost = $perSqrCost * $apartmentArea;
                    $costDataArray [] = [
                        'account_id' => $projectCost->id,
                        'cr_amount' => number_format($perApartmentCost,2),
                        'cost_center_id' => $costCenterId,
                    ];
                }
                $debitCOGS['account_id'] = '';
                $debitCOGS['dr_amount'] = $handover->sell->salesCollections->sum('received_amount');
                $debitCOGS['cost_center_id'] = $costCenterId;


                $apartmentName = $handover->sell->apartment->name;
                $clientName = $handover->sell->sellClients->first()->client->name;
                $clientAccountName = "$clientName-$projectName-$apartmentName";

                $incomeLine = BalanceAndIncomeLine::where('parent_id',49)->where('line_text', 'Like' , "%$projectName%")->first();
                $accountData['account_name']= "Sale-$clientAccountName";
                $accountData['account_type']= 4;
                $accountData['account_code']= "48-49-".$incomeLine->id.'-'.$handover->sell_id;
                $accountData['balance_and_income_line_id']= $incomeLine->id;

                $accReceivableData['account_name']= "Receivable-$clientAccountName";
                $accReceivableData['account_type']= 1;
                $accReceivableData['account_code']= "1-5-6".'-'.$handover->sell_id;
                $accReceivableData['balance_and_income_line_id']= 6;

                $accountCredit = $handover->sell->account()->updateOrCreate($accountData);
                $accountReceivableCr = $handover->sell->account()->updateOrCreate($accReceivableData);
                $accountDebit = Account::where('accountable_type',Sell::class)->where('accountable_id',$handover->sell_id)->where('account_type',2)->first();

                $transection['voucher_type'] = 'Journal';
                $transection['transaction_date'] = $handover->handover_date;
                $transection['user_id'] = auth()->user()->id;

                $debitLedger['account_id'] = $accountDebit->id;
                $debitLedger['dr_amount'] = $handover->sell->salesCollections->sum('received_amount');
                $debitLedger['cost_center_id'] = $costCenterId;
                $debitLedger['remarks'] = '';

                $creditLedger['account_id'] = $accountCredit->id;
                $creditLedger['cr_amount'] = $handover->sell->total_value;
                $creditLedger['cost_center_id'] = $costCenterId;
                $creditLedger['remarks'] = '';

                $dueLedger['account_id'] = $accountReceivableCr->id;
                $dueLedger['dr_amount'] = $handover->sell->total_value - $handover->sell->salesCollections->sum('received_amount');
                $dueLedger['cost_center_id'] = $costCenterId;
                $dueLedger['remarks'] = '';

//                dd($cogsArray,$costDataArray);
                $transectionCost = $handover->transaction()->create($transection);
                $transectionCost->ledgerEntries()->createMany($cogsArray);
                $transectionCost->ledgerEntries()->createMany($costDataArray);
                $transectionData = $handover->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
                $transectionData->ledgerEntries()->create($dueLedger);
            }
            return $status;
        }
    }

}
