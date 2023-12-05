<?php

namespace App\Http\Controllers\BD;

use App\BD\ProjectLayout;
use App\BD\BdFeasiRevenue;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;

use App\BD\BdFeasibilityEntry;
use Illuminate\Support\Facades\DB;
use App\Boq\Configurations\BoqFloor;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\BD\BdFeasiRevenueRequest;


class BdFeasiRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-revenue-view|bd-Feasibility-revenue-create|bd-Feasibility-revenue-edit|bd-Feasibility-revenue-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-revenue-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-revenue-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-revenue-delete', ['only' => ['destroy']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $BdFeasiRevenue = BdFeasiRevenue::latest()->get();
        return view('bd.revenue.index', compact('BdFeasiRevenue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.revenue.create', compact('locations', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasiRevenueRequest $request)
    {
        try{
            $request_data              = $request->only('location_id','revenue_from_parking','avg_rate','total_floor_sft','total_amount','total_saleable_sft','ground_floor_sft','mgc','actual_story','proposed_saleable_sft','proposed_saleable_sft','proposed_far','actual_far');
            $request_data['user_id']   = auth()->id();

            $request_details = [];
            foreach($request->floor_id as $key => $data)
            {
                $request_details[] = [
                    'floor_id'         =>  $request->floor_id[$key],
                    'floor_sft'        =>  $request->floor_sft[$key],
                    'rate'             =>  $request->rate[$key],
                    'total'            =>  $request->total[$key],
                ];
            }
            DB::transaction(function()use($request_data, $request_details){
                $BdFeasiRevenue= BdFeasiRevenue::create($request_data);
                $BdFeasiRevenue->BdFeasiRevenueDetail()->createMany($request_details);
            });

            return redirect()->route('revenue.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(BdFeasiRevenue $revenue)
    {
        $formType = "edit";
        $ground_floor = BoqFloor::where('name','like','Ground Floor')->get()->first();
        $storyData = ProjectLayout::query()
        ->where('bd_lead_location_id', $revenue->location_id)
        ->first();
        $floors = BoqFloor::
            where('name', 'LIKE', "%Floor%")
            ->get(['id','name'])
            ->toArray();
        $item = BdFeasibilityEntry::with('BdLeadGeneration', 'ProjectLayout')
            ->where('location_id', $revenue->location_id)
            ->first();
        $rfpl = $item->rfpl_ratio;
        $total_far = $item->ProjectLayout->total_far ?? 0;
        $land_size = $item->BdLeadGeneration?->land_size ?? 0;
        $global_total_buildup_area = (float)($total_far) * (float)($land_size) * 720;
        $story = $storyData ? ceil(explode(' ', $storyData->proposed_story)[2]) : 0;

        $total_buildup_area = $total_far * $land_size * 720;
        $total_bonus_saleable_area = $total_far * $land_size * 720 * ($item->bonus_saleable_area ?? 0) / 100;

        $total_saleable_area = ($total_buildup_area + $total_bonus_saleable_area) * ($item->rfpl_ratio ?? 0) / 100; 

        
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.revenue.create', compact('locations', 'formType', 'revenue','ground_floor','story','floors','land_size','rfpl','global_total_buildup_area','storyData','total_saleable_area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFeasiRevenueRequest $request, BdFeasiRevenue $revenue)
    {
        try{
            $request_data              = $request->only('location_id','avg_rate','revenue_from_parking','total_floor_sft','total_amount','total_saleable_sft','ground_floor_sft','mgc','actual_story','proposed_saleable_sft','proposed_far','actual_far');

            $request_details = [];
            foreach($request->floor_id as $key => $data)
            {
                $request_details[] = [
                    'floor_id'         =>  $request->floor_id[$key],
                    'floor_sft'        =>  $request->floor_sft[$key],
                    'rate'             =>  $request->rate[$key],
                    'total'            =>  $request->total[$key],
                ];
            }
            DB::transaction(function()use($revenue, $request_data, $request_details){
                $revenue->update($request_data);
                $revenue->BdFeasiRevenueDetail()->delete();
                $revenue->BdFeasiRevenueDetail()->createMany($request_details);
            });

            return redirect()->route('revenue.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(BdFeasiRevenue $revenue)
    {
        try{
            $revenue->delete();
            return redirect()->route('revenue.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('revenue.index')->withErrors($e->getMessage());
        }
    }
}
