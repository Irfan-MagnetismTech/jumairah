<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasibilitySubAndGenerator;
use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdFeasibilitySubAndGeneratorRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BdFeasibilitySubAndGeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($BdLeadGeneration_id)
    {
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        $Bd_sub_and_generators = BdFeasibilitySubAndGenerator::where('bd_leadgeneration_id',$BdLeadGeneration_id)->latest()->get(); 
        return view('bd.feasibility.location.sub-and-generator.index', compact('Bd_sub_and_generators', 'BdLeadGeneration_id', 'bd_lead_location_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($BdLeadGeneration_id)
    {
        $formType = 'create';
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        return view('bd.feasibility.location.sub-and-generator.create', compact('formType', 'BdLeadGeneration_id', 'bd_lead_location_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasibilitySubAndGeneratorRequest $request, $BdLeadGeneration_id)
    {
        try{
            $data = $request->all();
            $data['bd_leadgeneration_id'] = $BdLeadGeneration_id;
            BdFeasibilitySubAndGenerator::create($data);
            return redirect()->route('feasibility.location.sub-and-generator.index',$BdLeadGeneration_id)
            ->with('message', 'Sub And Generator has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.sub-and-generator.create')->withInput()->withErrors($e->getMessage());
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
    public function edit($BdLeadGeneration_id, $sub_and_generator_id)
    {
        $formType = 'edit';
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        $sub_and_generator = BdFeasibilitySubAndGenerator::findOrFail($sub_and_generator_id);
        return view('bd.feasibility.location.sub-and-generator.create', compact('formType', 'BdLeadGeneration_id', 'sub_and_generator_id', 'sub_and_generator', 'bd_lead_location_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFeasibilitySubAndGeneratorRequest $request, $BdLeadGeneration_id, $sub_and_generator_id)
    {
        try{
            $data = $request->all();
            $sub_and_generator = BdFeasibilitySubAndGenerator::findOrFail($sub_and_generator_id);
            $sub_and_generator->update($data);
            return redirect()->route('feasibility.location.sub-and-generator.index',$BdLeadGeneration_id)
            ->with('message', 'Sub And Generator has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.sub-and-generator.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($BdLeadGeneration_id, $sub_and_generator_id)
    {
        try{
            $sub_and_generator = BdFeasibilitySubAndGenerator::findOrFail($sub_and_generator_id);
            $sub_and_generator->delete();
            return redirect()->route('feasibility.location.sub-and-generator.index',$BdLeadGeneration_id)->with('message', 'Sub And Generator has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.sub-and-generator.create')->withErrors($e->getMessage());
        }
    }
}
