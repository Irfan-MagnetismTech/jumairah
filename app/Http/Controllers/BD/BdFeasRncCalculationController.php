<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasiRncCal;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class BdFeasRncCalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = BdFeasiRncCal::latest()->get();
        return view('bd.rnc_calculation.index',compact('datas'));
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
        $years = [2,2.5,3,3.5,4,4.5,5,5.5,6,6.5,7,7.5,8];
        return view('bd.rnc_calculation.create',compact('formType','locations','years'));
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
            DB::beginTransaction();
            $rnc_data['bd_lead_generation_id'] = $request->location_id; 
            $rnc_data['project_year'] = $request->year; 
            $cost_data = [];
            foreach($request->cons_1stper as  $key => $data){
                $cost_data = [
                    'row_1st'     =>  $request->cons_1stper[$key],
                    'row_2nd'     =>  $request->cons_2ndper[$key],
                    'row_3rd'     =>  $request->cons_3rdper[$key],
                    'row_4th'     =>  $request->cons_4thper[$key],
                    'row_5th'     =>  $request->cons_5thper[$key],
                    'row_6th'     =>  $request->cons_6thper[$key],
                    'row_7th'     =>  $request->cons_7thper[$key],
                    'row_8th'     =>  $request->cons_8thper[$key],
                    'row_9th'     =>  $request->cons_9thper[$key],
                    'row_10th'     =>  $request->cons_10thper[$key],
                ];
            }

            $sale_data = [];
            foreach($request->sales_1stper as  $key => $data){
                $sale_data = [
                    'row_1st'     =>  $request->sales_1stper[$key],
                    'row_2nd'     =>  $request->sales_2ndper[$key],
                    'row_3rd'     =>  $request->sales_3rdper[$key],
                    'row_4th'     =>  $request->sales_4thper[$key],
                    'row_5th'     =>  $request->sales_5thper[$key],
                    'row_6th'     =>  $request->sales_6thper[$key],
                    'row_7th'     =>  $request->sales_7thper[$key],
                    'row_8th'     =>  $request->sales_8thper[$key],
                    'row_9th'     =>  $request->sales_9thper[$key],
                    'row_10th'    =>  $request->sales_10thper[$key],
                ];
            }

            $rate_data = [];
            foreach($request->rate_1stper as  $key => $data){
                $rate_data = [
                    'row_1st'     =>  $request->rate_1stper[$key],
                    'row_2nd'     =>  $request->rate_2ndper[$key],
                    'row_3rd'     =>  $request->rate_3rdper[$key],
                    'row_4th'     =>  $request->rate_4thper[$key],
                    'row_5th'     =>  $request->rate_5thper[$key],
                    'row_6th'     =>  $request->rate_6thper[$key],
                    'row_7th'     =>  $request->rate_7thper[$key],
                    'row_8th'     =>  $request->rate_8thper[$key],
                    'row_9th'     =>  $request->rate_9thper[$key],
                    'row_10th'    =>  $request->rate_10thper[$key],
                ];
            }
            $BD_rnc = BdFeasiRncCal::create($rnc_data);
            $BD_rnc->BdFeasRncCalCost()->create($cost_data);
            $BD_rnc->BdFeasRncCalSale()->create($sale_data);
            $BD_rnc->BdFeasRncCalRate()->create($rate_data);
            
            DB::commit();
            return redirect()->route('rnc_calculation.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            DB::rollback();
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
    public function edit(BdFeasiRncCal $rncCalculation)
    {
        $formType = 'edit';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        $years = [2,2.5,3,3.5,4,4.5,5,5.5,6,6.5,7,7.5,8];
        return view('bd.rnc_calculation.create',compact('formType','locations','years','rncCalculation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BdFeasiRncCal $rncCalculation)
    {
        try{
            DB::beginTransaction();
            $rnc_data['bd_lead_generation_id'] = $request->location_id; 
            $rnc_data['project_year'] = $request->year; 
            $cost_data = [];
            foreach($request->cons_1stper as  $key => $data){
                $cost_data = [
                    'row_1st'     =>  $request->cons_1stper[$key],
                    'row_2nd'     =>  $request->cons_2ndper[$key],
                    'row_3rd'     =>  $request->cons_3rdper[$key],
                    'row_4th'     =>  $request->cons_4thper[$key],
                    'row_5th'     =>  $request->cons_5thper[$key],
                    'row_6th'     =>  $request->cons_6thper[$key],
                    'row_7th'     =>  $request->cons_7thper[$key],
                    'row_8th'     =>  $request->cons_8thper[$key],
                    'row_9th'     =>  $request->cons_9thper[$key],
                    'row_10th'     =>  $request->cons_10thper[$key],
                ];
            }

            $sale_data = [];
            foreach($request->sales_1stper as  $key => $data){
                $sale_data = [
                    'row_1st'     =>  $request->sales_1stper[$key],
                    'row_2nd'     =>  $request->sales_2ndper[$key],
                    'row_3rd'     =>  $request->sales_3rdper[$key],
                    'row_4th'     =>  $request->sales_4thper[$key],
                    'row_5th'     =>  $request->sales_5thper[$key],
                    'row_6th'     =>  $request->sales_6thper[$key],
                    'row_7th'     =>  $request->sales_7thper[$key],
                    'row_8th'     =>  $request->sales_8thper[$key],
                    'row_9th'     =>  $request->sales_9thper[$key],
                    'row_10th'    =>  $request->sales_10thper[$key],
                ];
            }

            $rate_data = [];
            foreach($request->rate_1stper as  $key => $data){
                $rate_data = [
                    'row_1st'     =>  $request->rate_1stper[$key],
                    'row_2nd'     =>  $request->rate_2ndper[$key],
                    'row_3rd'     =>  $request->rate_3rdper[$key],
                    'row_4th'     =>  $request->rate_4thper[$key],
                    'row_5th'     =>  $request->rate_5thper[$key],
                    'row_6th'     =>  $request->rate_6thper[$key],
                    'row_7th'     =>  $request->rate_7thper[$key],
                    'row_8th'     =>  $request->rate_8thper[$key],
                    'row_9th'     =>  $request->rate_9thper[$key],
                    'row_10th'    =>  $request->rate_10thper[$key],
                ];
            }
            $rncCalculation->update($rnc_data);
            $rncCalculation->BdFeasRncCalCost()->delete();
            $rncCalculation->BdFeasRncCalSale()->delete();
            $rncCalculation->BdFeasRncCalRate()->delete();
            $rncCalculation->BdFeasRncCalCost()->create($cost_data);
            $rncCalculation->BdFeasRncCalSale()->create($sale_data);
            $rncCalculation->BdFeasRncCalRate()->create($rate_data);
            
            DB::commit();
            return redirect()->route('rnc_calculation.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        }
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
