<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BD\BdFesiReferenceFess;
use Illuminate\Database\QueryException;
use App\Http\Requests\BD\BdFesiReferenceFessRequest;

class BdFesiReferenceFessController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-referene-fees-view|bd-Feasibility-referene-fees-create|bd-Feasibility-referene-fees-edit|bd-Feasibility-referene-fees-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-referene-fees-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-referene-fees-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-referene-fees-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reference_fees = BdFesiReferenceFess::latest()->get();
        return view('bd.configurations.reference-fees.index', compact('reference_fees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $type = [
            'Plan Approval Fees'     => 'Plan Approval Fees',
            'Environmental Clearance Fees'    => 'Environmental Clearance Fees'
        ];
        return view('bd.configurations.reference-fees.create', compact('formType', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFesiReferenceFessRequest $request)
    {
        try{
            $data = $request->all();
            BdFesiReferenceFess::create($data);
            return redirect()->route('reference_fees.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('reference_fees.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BdFesiReferenceFess $reference_fees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdFesiReferenceFess $reference_fee)
    {
        $formType = 'edit';
        $type = [
            'Plan Approval'     => 'Plan Approval',
            'Clearance Fees'    => 'Clearance Fees'
        ];
        $reference_fees = BdFesiReferenceFess::findOrFail($reference_fee->id);
        return view('bd.configurations.reference-fees.create', compact('formType', 'reference_fees', 'type'));
    }

    /**
     * Update the specified resource in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFesiReferenceFessRequest $request, BdFesiReferenceFess $reference_fee)
    {
        try{
            $data = $request->all();
            $reference_fees = BdFesiReferenceFess::findOrFail($reference_fee->id);
            $reference_fees->update($data);
            return redirect()->route('reference_fees.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('reference_fees.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdFesiReferenceFess $reference_fee)
    {
        try{
            $reference_fees = BdFesiReferenceFess::findOrFail($reference_fee->id);
            $reference_fees->delete();
            return redirect()->route('reference_fees.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('reference_fees.create')->withInput()->withErrors($e->getMessage());
        }
    }
}
