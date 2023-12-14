<?php

namespace App\Http\Controllers\Bd;

use App\BD\BdFeasibilityFar;
use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BdFeasibilityFarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($BdLeadGeneration_id)
    {
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        $Bd_far = BdFeasibilityFar::where('bd_leadgeneration_id',$BdLeadGeneration_id)->get(); 
        return view('bd.feasibility.location.far.index', compact('BdLeadGeneration_id', 'bd_lead_location_name', 'Bd_far'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
