<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\Depreciation;
use App\Accounts\FixedAsset;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepreciationRequest;
use App\Http\Requests\UpdateDepreciationRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Accounts;

class DepreciationController extends Controller
{

    public function index()
    {
        $depreciations = Depreciation::latest()->get();
        return view('accounts.depreciations.index',compact('depreciations'));
    }

    public function create()
    {
        return view('accounts.depreciations.create');
    }

    public function store(StoreDepreciationRequest $request)
    {
        try{
            $data = $request->only('date');
            $data['month'] = $request->month.'-01';
            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = $request->date;
            $transection['user_id'] = auth()->user()->id;

            $depreciationDetails =[];
            foreach ($request->fixed_asset_id as  $key => $detail){
                $depreciationDetails[]=[
                    'fixed_asset_id'=>$request->fixed_asset_id[$key],
                    'amount'=>$request->amount[$key],
                ];
            }

            DB::transaction(function()use($depreciationDetails, $data,$request,$transection){
                // dd($data);
                $depreciation= Depreciation::create($data);
                $dgd = $depreciation->depreciationDetails()->createMany($depreciationDetails);
                foreach ($depreciation->depreciationDetails as $depreciationDetail){
//                    $tag = $depreciationDetail->asset->tag;
                    $crAccount = $depreciationDetail->asset->account()->where('balance_and_income_line_id',4)->first();
                    $drAccount = $depreciationDetail->asset->account()->where('balance_and_income_line_id',86)->first();

                    $debitLedger['account_id'] = $drAccount->id;
                    $debitLedger['dr_amount'] = str_replace(',','',$depreciationDetail->amount);

                    $creditLedger['account_id'] = $crAccount->id;
                    $creditLedger['cr_amount'] = str_replace(',','',$depreciationDetail->amount);

                    $transectionData = $depreciation->transaction()->create($transection);
                    $transectionData->ledgerEntries()->create($debitLedger);
                    $transectionData->ledgerEntries()->create($creditLedger);
                }
            });

            return redirect()->route('depreciations.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('depreciations.index')->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Depreciation $depreciation)
    {
        //
    }

    public function edit(Depreciation $depreciation)
    {
        return view('accounts.depreciations.create',compact('depreciation'));
    }

    public function update(UpdateDepreciationRequest $request, Depreciation $depreciation)
    {
        try{
            $data = $request->only('date');
            $data['month'] = $request->month.'-01';
            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = $request->date;
            $transection['user_id'] = auth()->user()->id;

            $depreciationDetails =[];
            foreach ($request->fixed_asset_id as  $key => $detail){
                $depreciationDetails[]=[
                    'fixed_asset_id'=>$request->fixed_asset_id[$key],
                    'amount'=>$request->amount[$key],
                ];
            }


            DB::transaction(function()use($depreciationDetails, $data,$depreciation, $transection){
                $depreciation->update($data);
                $depreciation->depreciationDetails()->delete();
                $depreciation->depreciationDetails()->createMany($depreciationDetails);
                $depreciation->transaction()->delete();
                foreach ($depreciation->depreciationDetails as $depreciationDetail){
                    $tag = $depreciationDetail->asset->tag;
                    $crAccount = $depreciationDetail->asset->account()->where('balance_and_income_line_id',4)->first();
                    $drAccount = $depreciationDetail->asset->account()->where('balance_and_income_line_id',86)->first();

                    $debitLedger['account_id'] = $drAccount->id;
                    $debitLedger['dr_amount'] = str_replace(',','',$depreciationDetail->amount);

                    $creditLedger['account_id'] = $crAccount->id;
                    $creditLedger['cr_amount'] = str_replace(',','',$depreciationDetail->amount);

                    $transectionData = $depreciation->transaction()->create($transection);
                    $transectionData->ledgerEntries()->create($debitLedger);
                    $transectionData->ledgerEntries()->create($creditLedger);
                }
            });

            return redirect()->route('depreciations.index')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Depreciation $depreciation)
    {
        try {
            DB::transaction(function () use ($depreciation) {
                $depreciation->transaction()->delete();
                $depreciation->depreciationDetails()->delete();
                $depreciation->delete();
            });

            return redirect()->route('depreciations.index')->with('message', 'Data has been Delete Successfully');
        }catch (QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
