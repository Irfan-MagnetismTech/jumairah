<?php

namespace App\Http\Controllers\BD;

use App\BD\BdPriorityLand;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdPriorityLandRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriorityLandController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-priority-land-view|bd-priority-land-create|bd-priority-land-edit|bd-priority-land-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-priority-land-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-priority-land-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-priority-land-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_priority_land_data = BdPriorityLand::orderBy('year', 'desc')->get();
        $years = $bd_priority_land_data->groupBy('year')->all();
        return view('bd.priority-land.index', compact('years'));
    }

    /**
     * Display a listing of the monthList.
     *
     * @return \Illuminate\Http\Response
     */
    public function BdPriorityLandList($year)
    {
        $months = BdPriorityLand::where('year', $year)->orderBy('month', 'desc')->get();
        return view('bd.priority-land.bd-plan-list', compact('months'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('bd.priority-land.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdPriorityLandRequest $request)
    {
        try{
            $bd_priority_land_data                     = $request->only('applied_date', 'estimated_total_cost', 'estimated_total_sales_value', 'expected_total_profit');
            $bd_priority_land_data['year']             = $this->formatYear($request->applied_date);
            $bd_priority_land_data['month']            = $this->formatMonth($request->applied_date);
            $bd_priority_land_data['entry_by']         = auth()->id();

            $bd_priority_land_data_details = [];
            foreach($request->bd_lead_generation_details_id as $key => $data)
            {
                $bd_priority_land_data_details[] = [
                    'bd_lead_generation_details_id'     =>  $request->bd_lead_generation_details_id[$key],
                    'category'              =>  $request->category[$key],
                    'margin'                =>  $request->margin[$key],
                    'cash_benefit'          =>  $request->cash_benefit[$key],
                    'type'                  =>  $request->type[$key],
                    'status'                =>  $request->status[$key],
                    'expected_date'         =>  $request->expected_date[$key],
                    'estimated_cost'        =>  $request->estimated_cost[$key],
                    'estimated_sales_value' =>  $request->estimated_sales_value[$key],
                    'expected_profit'       =>  $request->expected_profit[$key]
                ];
            }
            
            DB::transaction(function()use($bd_priority_land_data, $bd_priority_land_data_details){
                $bd_priority_land = BdPriorityLand::create($bd_priority_land_data);
                $bd_priority_land->BdPriorityLandDetails()->createMany($bd_priority_land_data_details);
            });

            return redirect()->route('priority_land.index')->with('message', 'Information has been inserted successfully');
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
    public function show(BdPriorityLand $priority_land)
    {
        return view('bd.priority-land.create', compact('formType', 'priority_land'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdPriorityLand $priority_land)
    {
        $formType = "edit";
        return view('bd.priority-land.create', compact('formType', 'priority_land'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdPriorityLandRequest $request, BdPriorityLand $priority_land)
    {
        try{
            $bd_priority_land_data                     = $request->only('applied_date', 'estimated_total_cost', 'estimated_total_sales_value', 'expected_total_profit');
            $bd_priority_land_data['year']             = $this->formatYear($request->applied_date);
            $bd_priority_land_data['month']            = $this->formatMonth($request->applied_date);
            $bd_priority_land_data['entry_by']         = auth()->id();

            $bd_priority_land_data_details = [];
            foreach($request->bd_lead_generation_details_id as $key => $data)
            {
                $bd_priority_land_data_details[] = [
                    'bd_lead_generation_details_id'     =>  $request->bd_lead_generation_details_id[$key],
                    'category'              =>  $request->category[$key],
                    'margin'                =>  $request->margin[$key],
                    'cash_benefit'          =>  $request->cash_benefit[$key],
                    'type'                  =>  $request->type[$key],
                    'status'                =>  $request->status[$key],
                    'expected_date'         =>  $request->expected_date[$key],
                    'estimated_cost'        =>  $request->estimated_cost[$key],
                    'estimated_sales_value' =>  $request->estimated_sales_value[$key],
                    'expected_profit'       =>  $request->expected_profit[$key]
                ];
            }

            DB::transaction(function()use($priority_land, $bd_priority_land_data, $bd_priority_land_data_details){
                $priority_land->update($bd_priority_land_data);
                $priority_land->BdPriorityLandDetails()->delete();
                $priority_land->BdPriorityLandDetails()->createMany($bd_priority_land_data_details);
            });

            return redirect()->route('priority_land.index')->with('message', 'Information has been inserted successfully');
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
    public function destroy(BdPriorityLand $priority_land)
    {
        try{
            $priority_land->delete();
            return redirect()->route('bd_budget.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('priority_land.index')->withErrors($e->getMessage());
        }
    }


    public function pdf($id)
    {
        $priority_land = BdPriorityLand::where('id', $id)->get();
        return \PDF::loadview('bd.priority-land.pdf', compact('priority_land'))->setPaper('A4', 'landscape')->stream('bd-priority-land.pdf');
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

    /**
     *  Formats the date into m.
     *
     * @return string
     */
    private function formatMonth(string $date): string
    {
        return substr( date_format(date_create($date),"m"), 0);
    }
}
