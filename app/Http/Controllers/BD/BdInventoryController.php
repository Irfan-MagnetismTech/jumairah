<?php

namespace App\Http\Controllers\BD;

use App\BD\BdInventory;
use App\BD\BdInventoryDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdInventoryRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BdInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-inventory-view|bd-inventory-create|bd-inventory-edit|bd-inventory-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-inventory-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-inventory-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-inventory-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_inventory_data = BdInventory::orderBy('year', 'desc')->get();
        $years = $bd_inventory_data->groupBy('year')->all();
        return view('bd.inventory.index', compact('years'));
    }

    /**
     * Display a listing of the monthList.
     *
     * @return \Illuminate\Http\Response
     */
    public function BdInventoryList($year)
    {
        $bd_inventory_details = BdInventoryDetail::with('inventory')
        ->whereHas('inventory', function($q)use($year){
            return $q->where('year', $year)->groupBy('bd_inventory_id'); 
        })
        ->get(); 
        return view('bd.inventory.inventory-list', compact('bd_inventory_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('bd.inventory.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdInventoryRequest $request)
    {
        try{
            $bd_inventory_data                     = $request->only('applied_date', 'total_signing_money', 'total_inventory_value');
            $bd_inventory_data['year']             = $this->formatYear($request->applied_date);
            $bd_inventory_data['entry_by']         = auth()->id();

            $bd_inventory_details = [];
            foreach($request->cost_center_id as $key => $data)
            {
                $bd_inventory_details[] = [
                    'cost_center_id'    =>  $request->cost_center_id[$key],
                    'land_size'         =>  $request->land_size[$key],
                    'ratio'             =>  $request->ratio[$key],
                    'total_units'       =>  $request->total_units[$key],
                    'lo_units'          =>  $request->lo_units[$key],
                    'lo_space'          =>  $request->lo_space[$key],
                    'rfpl_units'        =>  $request->rfpl_units[$key],
                    'rfpl_space'        =>  $request->rfpl_space[$key],
                    'margin'            =>  $request->margin[$key],
                    'rate'              =>  $request->rate[$key],
                    'parking'           =>  $request->parking[$key],
                    'utility'           =>  $request->utility[$key],
                    'other_benefit'     =>  $request->other_benefit[$key],
                    'remarks'           =>  $request->remarks[$key],
                    'signing_money'     =>  $request->signing_money[$key],
                    'inventory_value'   =>  $request->inventory_value[$key]
                ];
            }

            DB::transaction(function()use($bd_inventory_data, $bd_inventory_details){
                $bd_inventory = BdInventory::create($bd_inventory_data);
                $bd_inventory->BdInventoryDetails()->createMany($bd_inventory_details);
            });

            return redirect()->route('bd_inventory.index')->with('message', 'Inventory data has been inserted successfully');
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
    public function show(BdInventory $bd_inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdInventory $bd_inventory)
    {
        $formType = "edit";
        return view('bd.inventory.create', compact('formType', 'bd_inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdInventoryRequest $request, BdInventory $bd_inventory)
    {
        try{
            $bd_inventory_data                     = $request->only('applied_date', 'total_signing_money', 'total_inventory_value');
            $bd_inventory_data['year']             = $this->formatYear($request->applied_date);
            $bd_inventory_data['entry_by']         = auth()->id();

            $bd_inventory_details = [];
            foreach($request->cost_center_id as $key => $data)
            {
                $bd_inventory_details[] = [
                    'cost_center_id'    =>  $request->cost_center_id[$key],
                    'land_size'         =>  $request->land_size[$key],
                    'ratio'             =>  $request->ratio[$key],
                    'total_units'       =>  $request->total_units[$key],
                    'lo_units'          =>  $request->lo_units[$key],
                    'lo_space'          =>  $request->lo_space[$key],
                    'rfpl_units'        =>  $request->rfpl_units[$key],
                    'rfpl_space'        =>  $request->rfpl_space[$key],
                    'margin'            =>  $request->margin[$key],
                    'rate'              =>  $request->rate[$key],
                    'parking'           =>  $request->parking[$key],
                    'utility'           =>  $request->utility[$key],
                    'other_benefit'     =>  $request->other_benefit[$key],
                    'remarks'           =>  $request->remarks[$key],
                    'signing_money'     =>  $request->signing_money[$key],
                    'inventory_value'   =>  $request->inventory_value[$key]
                ];
            }
            
            DB::transaction(function()use($bd_inventory, $bd_inventory_data, $bd_inventory_details){
                $bd_inventory->update($bd_inventory_data);
                $bd_inventory->BdInventoryDetails()->delete();
                $bd_inventory->BdInventoryDetails()->createMany($bd_inventory_details);
            });

            return redirect()->route('bd_inventory.index')->with('message', 'Inventory data has been inserted successfully');
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
    public function destroy(BdInventory $bd_inventory)
    {
        try{
            $bd_inventory->delete();
            return redirect()->route('bd_inventory.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bd_inventory.index')->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $bd_inventory = BdInventory::where('id', $id)->get();
        return \PDF::loadview('bd.inventory.pdf', compact('bd_inventory'))->setPaper('A4', 'landscape')->stream('bd-inventory.pdf');
    }

    /**
     *  Formats the date into y.
     *
     * @return string
     */
    private function formatYear(string $date): string
    {
        return substr( date_format(date_create($date),"y"), 0);
    }
}
