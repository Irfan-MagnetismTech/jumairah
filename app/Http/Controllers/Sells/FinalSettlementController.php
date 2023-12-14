<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Sells\FinalSettlement;
use App\Http\Requests\StoreFinalSettlementRequest;
use App\Http\Requests\UpdateFinalSettlementRequest;
use Illuminate\Database\QueryException;

class FinalSettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finalsettlements =FinalSettlement::latest()->get();
        return view('sales/final-settlements.index', compact('finalsettlements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = [];
        return view('sales/final-settlements.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFinalSettlementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFinalSettlementRequest $request)
    {
        try{
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            FinalSettlement::create($data);
            return redirect()->route('final-settlements.create')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FinalSettlement  $finalSettlement
     * @return \Illuminate\Http\Response
     */
    public function show(FinalSettlement $finalSettlement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FinalSettlement  $finalSettlement
     * @return \Illuminate\Http\Response
     */
    public function edit(FinalSettlement $finalSettlement)
    {
        $clients = [];
        return view('sales/final-settlements.create', compact('clients','finalSettlement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFinalSettlementRequest  $request
     * @param  \App\FinalSettlement  $finalSettlement
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFinalSettlementRequest $request, FinalSettlement $finalSettlement)
    {
        try{
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $finalSettlement->update($data);
            return redirect()->route('final-settlements.index')->with('message', 'Data has been Updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FinalSettlement  $finalSettlement
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinalSettlement $finalSettlement)
    {
        try{
            $finalSettlement->delete();
            return redirect()->route('final-settlements.index')->with('message', 'Data has been Deleted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
