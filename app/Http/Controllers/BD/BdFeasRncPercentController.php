<?php

namespace App\Http\Controllers\BD;

use Exception;
use App\BD\BdFeasRncPercent;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BdFeasRncPercentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = BdFeasRncPercent::latest()->get();
        return view('bd.rnc_percent.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        
        return view('bd.rnc_percent.create',compact('formType','locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request_data['bd_lead_generation_id'] = $request->location_id;
            $request_data['user_id'] = auth()->id();
            $details = [];
            foreach($request->cons_year as $key => $data)
            {
                $details[] = [
                    'project_year'            =>  $request->cons_year[$key],
                    'cent_1st'                =>  $request->cons_1stper[$key],
                    'cent_2nd'                =>  $request->cons_2ndper[$key],
                    'cent_3rd'                =>  $request->cons_3rdper[$key],
                    'cent_4th'                =>  $request->cons_4thper[$key],
                    'cent_5th'                =>  $request->cons_5thper[$key],
                    'cent_6th'                =>  $request->cons_6thper[$key],
                    'cent_7th'                =>  $request->cons_7thper[$key],
                    'cent_8th'                =>  $request->cons_8thper[$key],
                    'cent_9th'                =>  $request->cons_9thper[$key],
                    'cent_10th'               =>  $request->cons_10thper[$key],
                    'type'                    =>  0,
                ];
            }

            foreach($request->sales_year as $key => $data)
            {
                $details[] = [
                    'project_year'            =>  $request->sales_year[$key],
                    'cent_1st'                =>  $request->sales_1stper[$key],
                    'cent_2nd'                =>  $request->sales_2ndper[$key],
                    'cent_3rd'                =>  $request->sales_3rdper[$key],
                    'cent_4th'                =>  $request->sales_4thper[$key],
                    'cent_5th'                =>  $request->sales_5thper[$key],
                    'cent_6th'                =>  $request->sales_6thper[$key],
                    'cent_7th'                =>  $request->sales_7thper[$key],
                    'cent_8th'                =>  $request->sales_8thper[$key],
                    'cent_9th'                =>  $request->sales_9thper[$key],
                    'cent_10th'               =>  $request->sales_10thper[$key],
                    'type'                    =>  1,
                ];
            }

            DB::transaction(function()use($request_data, $details){
                $rnc_percent = BdFeasRncPercent::create($request_data);
                $rnc_percent->BdFeasRncPercentDetail()->createMany($details);
            });

            return redirect()->route('rnc_percent.index')->with('message', 'Data been inserted successfully');
        }catch(Exception $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
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
    public function edit(BdFeasRncPercent $rncPercent)
    {
        $formType = 'edit';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.rnc_percent.create',compact('formType','locations','rncPercent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BdFeasRncPercent $rncPercent)
    {
        try{
            $request_data['bd_lead_generation_id'] = $request->location_id;
            $details = [];
            foreach($request->cons_year as $key => $data)
            {
                $details[] = [
                    'project_year'            =>  $request->cons_year[$key],
                    'cent_1st'                =>  $request->cons_1stper[$key],
                    'cent_2nd'                =>  $request->cons_2ndper[$key],
                    'cent_3rd'                =>  $request->cons_3rdper[$key],
                    'cent_4th'                =>  $request->cons_4thper[$key],
                    'cent_5th'                =>  $request->cons_5thper[$key],
                    'cent_6th'                =>  $request->cons_6thper[$key],
                    'cent_7th'                =>  $request->cons_7thper[$key],
                    'cent_8th'                =>  $request->cons_8thper[$key],
                    'cent_9th'                =>  $request->cons_9thper[$key],
                    'cent_10th'               =>  $request->cons_10thper[$key],
                    'type'                    =>  0,
                ];
            }

            foreach($request->sales_year as $key => $data)
            {
                $details[] = [
                    'project_year'            =>  $request->sales_year[$key],
                    'cent_1st'                =>  $request->sales_1stper[$key],
                    'cent_2nd'                =>  $request->sales_2ndper[$key],
                    'cent_3rd'                =>  $request->sales_3rdper[$key],
                    'cent_4th'                =>  $request->sales_4thper[$key],
                    'cent_5th'                =>  $request->sales_5thper[$key],
                    'cent_6th'                =>  $request->sales_6thper[$key],
                    'cent_7th'                =>  $request->sales_7thper[$key],
                    'cent_8th'                =>  $request->sales_8thper[$key],
                    'cent_9th'                =>  $request->sales_9thper[$key],
                    'cent_10th'               =>  $request->sales_10thper[$key],
                    'type'                    =>  1,
                ];
            }

            DB::transaction(function()use($request_data, $details,$rncPercent){
                $rncPercent->update($request_data);
                $rncPercent->BdFeasRncPercentDetail()->delete();
                $rncPercent->BdFeasRncPercentDetail()->createMany($details);
            });

            return redirect()->route('rnc_percent.index')->with('message', 'Data been updated successfully');
        }catch(Exception $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdFeasRncPercent $rncPercent)
    {
        try{
            $rncPercent->delete();
            return redirect()->route('rnc_percent.index')->with('message', 'Data has been deleted successfully');
        }catch(Exception $e){
            return redirect()->route('rnc_percent.index')->withErrors($e->getMessage());
        }
    }
}
