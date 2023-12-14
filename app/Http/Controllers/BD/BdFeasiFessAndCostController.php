<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasiFessAndCost;
use App\BD\BdFeasiPerticular;
use App\BD\BdFesiReferenceFess;
use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdFeasiFessAndCostRequest;
use App\Procurement\NestedMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BdFeasiFessAndCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-Fees-Cost-view|bd-Feasibility-Fees-Cost-create|bd-Feasibility-Fees-Cost-edit|bd-Feasibility-Fees-Cost-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-Fees-Cost-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-Fees-Cost-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-Fees-Cost-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $BdFeasiFessAndCost = BdFeasiFessAndCost::with('BdFeasiFessAndCostDetail.headable')->latest()->get();
        // dd($BdFeasiFessAndCost->pluck('BdFeasiFessAndCostDetail')->flatten()->pluck('headable')
        // ->groupBy('type'));
        return view('bd.fees-cost.index', compact('BdFeasiFessAndCost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $data = BdFeasiPerticular::query()
                    ->whereIn('type',['Permission Fees','Utility'])
                    ->with(['unit' => fn ($query) => $query->select('id', 'name')])
                    ->select('id','name','unit_id','type')
                    ->get()
                    ->groupBy('type');
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.fees-cost.create', compact('locations', 'formType','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasiFessAndCostRequest $request)
    {
        try{
            $request_data                     = $request->only('location_id');
            $request_data['user_id']          = auth()->id();

            $details = [];
            if($request->reference_headble_id && $request->reference_headble_id[0]){
                foreach($request->reference_headble_id as $key => $data)
                {
                    $details[] = [
                        'headble_id'                =>  $request->reference_headble_id[$key],
                        'headble_type'              =>  BdFesiReferenceFess::class,
                        'calculation'               =>  $request->reference_calculation[$key] ?? 0,
                        'rate'                      =>  $request->reference_rate[$key],
                        'quantity'                  =>  1,
                        'remarks'                   =>  $request->reference_remarks[$key]
                    ];
                }
            }
            if($request->generator_headble_id && $request->generator_headble_id[0]){
                foreach($request->generator_headble_id as $key => $data)
                {
                    $details[] = [
                        'headble_id'                =>  $request->generator_headble_id[$key],
                        'headble_type'              =>  NestedMaterial::class,
                        'calculation'               =>  $request->generator_calculation[$key] ?? 0,
                        'rate'                      =>  $request->generator_rate[$key],
                        'quantity'                  =>  $request->generator_quantity[$key],
                        'remarks'                   =>  $request->generator_remarks[$key]
                    ];
                }
            }

            if($request->permission_headble_id){
               
                foreach($request->permission_headble_id as $key => $datas)
                {   
                    foreach($datas as $ke => $value){
                        $details[] = [
                            'headble_id'                =>  $request->permission_headble_id[$key][$ke],
                            'headble_type'              =>  BdFeasiPerticular::class,
                            'calculation'               =>  $request->permission_calculation[$key][$ke] ?? 0,
                            'rate'                      =>  $request->permission_rate[$key][$ke] ?? 0,
                            'quantity'                  =>  $request->permission_quantity[$key][$ke] ?? 0,
                            'remarks'                   =>  $request->permission_remarks[$key][$ke]
                        ];
                    }
                }
    
            }
            DB::transaction(function()use($request_data, $details){
                $bd_feasi_fees_cost= BdFeasiFessAndCost::create($request_data);
                $bd_feasi_fees_cost->BdFeasiFessAndCostDetail()->createMany($details);
            });

            return redirect()->route('fees_cost.index')->with('message', 'Cost has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function BoqFeesCostCreate()
    {
        $formType = "create";
        $data = BdFeasiPerticular::query()
                    ->whereIn('type',['Substructure','Superstructure & Finishing','BOQ-Utility','EME'])
                    ->with(['unit' => fn ($query) => $query->select('id', 'name')])
                    ->select('id','name','unit_id','type')
                    ->get()
                    ->groupBy('type');
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.fees-cost.boq_create', compact('locations', 'formType','data'));
    }
    
    public function RefFeesCreate()
    {
        $formType = "create";
        $data = BdFeasiPerticular::query()
                    ->whereIn('type',['Substructure','Superstructure & Finishing','BOQ-Utility','EME'])
                    ->with(['unit' => fn ($query) => $query->select('id', 'name')])
                    ->select('id','name','unit_id')
                    ->get();
        
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.fees-cost.reffee_and_other_create', compact('locations', 'formType','data'));
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
        $formType = "edit";
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');;
        $fees_cost = BdFeasiFessAndCost::findOrFail($id);

        if($fees_cost->BdFeasiFessAndCostDetail->contains('headble_type',BdFeasiPerticular::class)){
            $particulars = ['Permission Fees','Utility'];
            $type_array[] = $fees_cost->BdFeasiFessAndCostDetail->first()->headable->type;
            $count = count(array_intersect($particulars,$type_array));
            if($count){
                $details = [];
                $fees_cost->BdFeasiFessAndCostDetail
                         ->map(function($item,$key)use(&$details){
                                $details[$item->headable->type][] = $item;  
                        });
                
                return view('bd.fees-cost.create', compact('locations', 'formType','fees_cost','details'));
            }else{
                $details = [];
                $fees_cost->BdFeasiFessAndCostDetail
                         ->map(function($item,$key)use(&$details){
                                $details[$item->headable->type][] = $item;
                        });
                return view('bd.fees-cost.boq_create', compact('locations', 'formType','fees_cost','details'));
            }
        }else{
            return view('bd.fees-cost.reffee_and_other_create', compact('formType','locations','fees_cost'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BdFeasiFessAndCost $feesCost)
    {
        try{
            $request_data                     = $request->only('location_id');
            $request_data['user_id']          = auth()->id();

            $details = [];
            if($request->reference_headble_id && $request->reference_headble_id[0]){
                foreach($request->reference_headble_id as $key => $data)
                {
                    $details[] = [
                        'headble_id'                =>  $request->reference_headble_id[$key],
                        'headble_type'              =>  BdFesiReferenceFess::class,
                        'calculation'               =>  $request->reference_calculation[$key] ?? 0,
                        'rate'                      =>  $request->reference_rate[$key],
                        'quantity'                  =>  1,
                        'remarks'                   =>  $request->reference_remarks[$key]
                    ];
                }
            }
            if($request->generator_headble_id && $request->generator_headble_id[0]){
                foreach($request->generator_headble_id as $key => $data)
                {
                    $details[] = [
                        'headble_id'                =>  $request->generator_headble_id[$key],
                        'headble_type'              =>  NestedMaterial::class,
                        'calculation'               =>  $request->generator_calculation[$key] ?? 0,
                        'rate'                      =>  $request->generator_rate[$key],
                        'quantity'                  =>  $request->generator_quantity[$key],
                        'remarks'                   =>  $request->generator_remarks[$key]
                    ];
                }
            }

            if($request->permission_headble_id){
               
                foreach($request->permission_headble_id as $key => $datas)
                {   
                    foreach($datas as $ke => $value){
                        $details[] = [
                            'headble_id'                =>  $request->permission_headble_id[$key][$ke],
                            'headble_type'              =>  BdFeasiPerticular::class,
                            'calculation'               =>  $request->permission_calculation[$key][$ke] ?? 0,
                            'rate'                      =>  $request->permission_rate[$key][$ke] ?? 0,
                            'quantity'                  =>  $request->permission_quantity[$key][$ke] ?? 0,
                            'remarks'                   =>  $request->permission_remarks[$key][$ke]
                        ];
                    }
                }
    
            }
            DB::transaction(function()use($request_data, $details,$feesCost){
                $feesCost->update($request_data);
                $feesCost->BdFeasiFessAndCostDetail()->delete();
                $feesCost->BdFeasiFessAndCostDetail()->createMany($details);
            });

            return redirect()->route('fees_cost.index')->with('message', 'Cost has been updated successfully');
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
    public function destroy(BdFeasiFessAndCost $feesCost)
    {
        try{
            $feesCost->delete();
            return redirect()->route('fees_cost.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('fees_cost.index')->withErrors($e->getMessage());
        }
    }
}
