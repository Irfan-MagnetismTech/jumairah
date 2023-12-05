<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasiPerticular;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdFeasi_perticularRequest;
use App\Procurement\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BdFeasi_perticularController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-particuler-view|bd-Feasibility-particuler-create|bd-Feasibility-particuler-edit|bd-Feasibility-particuler-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-particuler-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-particuler-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-particuler-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perticulars = BdFeasiPerticular::with('feesAndCosts')->latest()->get();
        return view('bd.configurations.perticulars.index', compact('perticulars'));
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
            'Permission Fees'               => 'Permission Fees',
            'Substructure'                  => 'Substructure',
            'Superstructure & Finishing'    => 'Superstructure & Finishing',
            'BOQ-Utility'                       => 'BOQ-Utility',
            'Utility'                       => 'Utility',
            'EME'                           => 'EME'
        ];
        $units = Unit::orderBy('id')->pluck('name', 'id');
        return view('bd.configurations.perticulars.create', compact('formType', 'type', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasi_perticularRequest $request)
    {
        try{
            $data = $request->all();
            BdFeasiPerticular::create($data);
            return redirect()->route('feasi_perticular.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('feasi_perticular.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdFeasiPerticular $feasi_perticular)
    {
        $formType = 'edit';
        $type = [
            'Permission Fees'               => 'Permission Fees',
            'Substructure'                  => 'Substructure',
            'Superstructure & Finishing'    => 'Superstructure & Finishing',
            'Utility'                       => 'Utility',
            'BOQ-Utility'                       => 'BOQ-Utility',
            'EME'                           => 'EME'
        ];
        $units = Unit::orderBy('id')->pluck('name', 'id');
        $BdFeasi_perticular = BdFeasiPerticular::findOrFail($feasi_perticular->id);
        return view('bd.configurations.perticulars.create', compact('formType', 'BdFeasi_perticular', 'type', 'units'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFeasi_perticularRequest $request, BdFeasiPerticular $feasi_perticular)
    {
        try{
            $data = $request->all();
            $BdFeasi_perticular = BdFeasiPerticular::findOrFail($feasi_perticular->id);
            $BdFeasi_perticular->update($data);
            return redirect()->route('feasi_perticular.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('feasi_perticular.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdFeasiPerticular $feasi_perticular)
    {
        try{
            $BdFeasi_perticular = BdFeasiPerticular::findOrFail($feasi_perticular->id);
            $BdFeasi_perticular->delete();
            return redirect()->route('feasi_perticular.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('feasi_perticular.create')->withInput()->withErrors($e->getMessage());
        }
    }
}
