<?php

namespace App\Http\Controllers\CSD;

use App\CSD\CsdMaterialRate;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSD\CsdMaterialRateRequest;
use App\Http\Requests\CSD\CsdMaterialRequest;
use App\Procurement\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsdMaterialRateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:csd-material-rate-view|csd-material-rate-create|csd-material-rate-edit|csd-material-rate-delete', ['only' => ['index','show']]);
        $this->middleware('permission:csd-material-rate-create', ['only' => ['create','store']]);
        $this->middleware('permission:csd-material-rate-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:csd-material-rate-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material_rate = CsdMaterialRate::with('csdMaterials')->latest()->get();
        return view('csd.rate.index', compact('material_rate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $material_rate = CsdMaterialRate::orderBy('id', 'desc');
        $units = Unit::orderBy('name')->pluck('name', 'id');
        return view('csd.rate.create', compact('formType', 'material_rate', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsdMaterialRateRequest $request)
    {
        try{
            $material_rate_data = array();
            foreach($request->material_id as  $key => $data){
                $material_rate_data[] = [
                    'material_id'   =>$request->material_id[$key],
                    'unit_id'       =>$request->unit_id[$key],
                    'actual_rate'   =>$request->actual_rate[$key],
                    'demand_rate'   =>$request->demand_rate[$key],
                    'refund_rate'   =>$request->refund_rate[$key]
                ];
            }

            DB::transaction(function()use($material_rate_data){
                CsdMaterialRate::insert($material_rate_data);
            });

            return redirect()->route('csd.material_rate.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
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
    public function edit(CsdMaterialRate $material_rate)
    {
        $formType = "edit";
        $units = Unit::orderBy('name')->pluck('name', 'id');
        $rate = CsdMaterialRate::where('id', $material_rate->id)->first();
        return view('csd.rate.create', compact('rate',  'formType',  'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CsdMaterialRateRequest $request, CsdMaterialRate $material_rate)
    {
        try{
            $material_rate_data = $request->only('material_id','unit_id','actual_rate','demand_rate' ,'refund_rate');
            DB::transaction(function()use($material_rate, $material_rate_data){
                $material_rate->update($material_rate_data);
            });

            return redirect()->route('csd.material_rate.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CsdMaterialRate $material_rate)
    {
        try{
            $material_rate->delete();
            return redirect()->route('csd.material_rate.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('csd.material_rate.create')->withErrors($e->getMessage());
        }
    }
}
