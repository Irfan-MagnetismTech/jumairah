<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\FixedAsset;
use App\CostCenter;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedAssetRequest;
use App\Http\Requests\UpdateFixedAssetRequest;
use Dompdf\Positioner\Fixed;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fixedAssets = FixedAsset::latest()->get();

        return view('accounts.fixed-assets.index', compact('fixedAssets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $particularHeads = [
            'Carry Cost'        => 'Carry Cost',
            'Process Cost'      => 'Process Cost',
            'Purchase Value'    => 'Purchase Value',
            'Installation Cost' => 'Installation Cost',
            'Insurance Cost'    => 'Insurance Cost',
            'Any Other Cost'    => 'Any Other Cost',
        ];
        $departments = Department::pluck('name', 'id');
        $costCenters = CostCenter::pluck('name','id');
        $accounts = Account::where('balance_and_income_line_id', 34)->where('parent_account_id', '!=',null)->pluck('account_name','id');
        $assetCategories = Account::where('balance_and_income_line_id',3)->where('parent_account_id','!=',null)->pluck('account_name', 'id');
        return view('accounts.fixed-assets.create',compact('departments','costCenters','assetCategories', 'accounts','particularHeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFixedAssetRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFixedAssetRequest $request)
    {
        try {
            $costs = [];
            foreach ($request->particular as $key => $data)
            {
                $costs[] = [
                    'particular' => $request->particular[$key],
                    'amount'     => $request->amount[$key],
                ];
            }

            $ADAccount['account_code'] = '1-2-4-'.
            $ADAccount['balance_and_income_line_id'] = 4;
            $ADAccount['account_name'] = 'Accumulated Depreciation - ' .$request->tag;
            $ADAccount['account_type'] = 1;

            $depreciationAccount['account_code'] = '74-85-86-'.
            $depreciationAccount['balance_and_income_line_id'] = 86;
            $depreciationAccount['account_name'] = 'Depreciation - ' .$request->tag;
            $depreciationAccount['account_type'] = 5;

            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = now()->format('d-m-Y');
            $transection['bill_no'] = $request->bill_no;
            $transection['cheque_number'] = $request->cheque_number;
            $transection['cheque_type'] = $request->cheque_type;
            $transection['cheque_date'] = $request->cheque_date;
            $transection['user_id'] = auth()->user()->id;

            $debitLedger['account_id'] = $request->account_id;
            $debitLedger['dr_amount'] = $request->total_amount;
            $debitLedger['cost_center_id'] = $request->cost_center_id;

            $creditLedger['account_id'] = $request->name;
            // $creditLedger['account_id'] = $request->cr_account_id;
            $creditLedger['cr_amount'] = $request->total_amount;
            $creditLedger['cost_center_id'] = $request->cost_center_id;

            DB::transaction(function () use ($request, $costs,$transection,$debitLedger,$creditLedger,$ADAccount,$depreciationAccount)
            {
                $fixedData = $request->all();
                $fixedData['price'] = $request->total_amount;

                $asset = FixedAsset::create($request->all());
                $asset->fixedAssetCosts()->createMany($costs);
                $asset->account()->create($ADAccount);
                $asset->account()->create($depreciationAccount);
                $transectionData = $asset->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
            });

            return redirect()->route('fixed-assets.index')->with('message', 'Data has been inserted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accounts\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function show(FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accounts\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedAsset $fixedAsset)
    {
//        dd($fixedAsset->account);
        $particularHeads = [
            'Carray Cost'       => 'Carray Cost',
            'Prcess Cost'       => 'Prcess Cost',
            'Purchase Value'    => 'Purchase Value',
            'Installation Cost' => 'Installation Cost',
            'Insurance Cost'    => 'Insurance Cost',
            'Any Other Cost'    => 'Any Other Cost',
        ];
        $departments = Department::pluck('name', 'id');
        $accounts = Account::where('balance_and_income_line_id', 34)->pluck('account_name','id');
        $assetCategories = Account::where('balance_and_income_line_id',3)->where('parent_account_id','!=',null)->pluck('account_name', 'id');
        $costCenters = CostCenter::pluck('name','id');
        return view('accounts.fixed-assets.create', compact('departments','accounts','costCenters','particularHeads', 'fixedAsset', 'assetCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFixedAssetRequest  $request
     * @param  \App\Accounts\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFixedAssetRequest $request, FixedAsset $fixedAsset)
    {
        try {
            $fixedData = $request->except('total_amount','particular','amount');
            $fixedData['price'] = $request->total_amount;
            $costs = [];
            foreach ($request->particular as $key => $data)
            {
                $costs[] = [
                    'particular' => $request->particular[$key],
                    'amount'     => $request->amount[$key],
                ];
            }

            $ADAccount['account_code'] = '1-2-4-'.
            $ADAccount['balance_and_income_line_id'] = 4;
            $ADAccount['account_name'] = 'Accumulated Depreciation - ' .$request->tag;
            $ADAccount['account_type'] = 1;

            $depreciationAccount['account_code'] = '74-85-86'.
            $depreciationAccount['balance_and_income_line_id'] = 86;
            $depreciationAccount['account_name'] = 'Depreciation - ' .$request->tag;
            $depreciationAccount['account_type'] = 5;

            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = now()->format('d-m-Y');
            $transection['bill_no'] = $request->bill_no;
            $transection['cheque_number'] = $request->cheque_number;
            $transection['cheque_type'] = $request->cheque_type;
            $transection['cheque_date'] = $request->cheque_date;
            $transection['user_id'] = auth()->user()->id;

            $debitLedger['account_id'] = $request->account_id;
            $debitLedger['dr_amount'] = $request->total_amount;
            $debitLedger['cost_center_id'] = $request->cost_center_id;

            $creditLedger['account_id'] = $request->cr_account_id;
            $creditLedger['cr_amount'] = $request->total_amount;
            $creditLedger['cost_center_id'] = $request->cost_center_id;

            DB::transaction(function () use ($fixedData, $costs, $fixedAsset, $ADAccount, $depreciationAccount, $transection, $debitLedger,$creditLedger)
            {
                $fixedAsset->update($fixedData);
                $fixedAsset->fixedAssetCosts()->delete();
                $fixedAsset->fixedAssetCosts()->createMany($costs);
                $fixedAsset->account()->delete();
                $fixedAsset->transaction()->delete();
                $fixedAsset->account()->create($ADAccount);
                $fixedAsset->account()->create($depreciationAccount);
                $transectionData = $fixedAsset->transaction()->create($transection);
                $transectionData->ledgerEntries()->create($debitLedger);
                $transectionData->ledgerEntries()->create($creditLedger);
            });


            return redirect()->route('fixed-assets.index')->with('message', 'Data has been inserted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accounts\FixedAsset  $fixedAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedAsset $fixedAsset)
    {
        try {
            DB::transaction(function () use ($fixedAsset){
                $fixedAsset->delete();
                $fixedAsset->account()->delete();
                $fixedAsset->transaction()->delete();
            });
            return redirect()->route('fixed-assets.index')->with('message', 'Data has been deleted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
