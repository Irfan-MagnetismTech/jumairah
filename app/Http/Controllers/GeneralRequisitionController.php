<?php

namespace App\Http\Controllers;

use App\Approval\ApprovalLayer;
use App\Approval\ApprovalLayerDetails;
use App\Http\Requests\GeneralRequisitioinRequest;
use App\Http\Requests\RequisitionRequest;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\Requisition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class GeneralRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitions = Requisition::whereNotNull('condition')->latest()->get();
        return view('general-requisition.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType     = "create";
        // $ApprovalLayerName = ApprovalLayer::where('name','like','General Requisition%')
        // // ->where('department_id',auth()->user()->department?->id)
        // ->pluck('name','id');
        $ApprovalLayerName = ApprovalLayer::where('name', 'General Requisition')->first();
        return view('general-requisition.create', compact('formType', 'ApprovalLayerName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralRequisitioinRequest $request)
    {
        try{
            $requisitionData = $request->only('mpr_no', 'cost_center_id', 'applied_date', 'note', 'remarks', 'approval_layer_id');
            $requisitionData['requisition_by']  = auth()->id();
            $requisitionData['status']          = "Pending";
            $requisitionData['condition']       = "general requisition";

            $requisitionDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requisitionDetailData[] = [
                    'floor_id'      =>  !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'required_date' =>  $request->required_date[$key]
                ];
            }

            DB::transaction(function()use($requisitionData, $requisitionDetailData){
                $requisition = Requisition::create($requisitionData);
                $requisition->requisitiondetails()->createMany($requisitionDetailData);
            });

            return redirect()->route('general-requisitions.index')->with('message', 'Data has been inserted successfully');
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
    public function show(Requisition $general_requisition)
    {
        return view('general-requisition.show', compact('general_requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $general_requisition)
    {
        $formType = "edit";
        $general_requisition->load('requisitionDetails.nestedMaterial.boqSupremeBudgets');
        // $ApprovalLayerName = ApprovalLayer::where('name','like','General Requisition%')
        // // ->where('department_id',auth()->user()?->department?->id)
        // ->pluck('name','id');
        $ApprovalLayerName = ApprovalLayer::where('name', 'General Requisition')->first();
        return view('general-requisition.create', compact('general_requisition','formType', 'ApprovalLayerName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GeneralRequisitioinRequest $request, Requisition $general_requisition)
    {
        try{
            $requisitionData = $request->only( 'note', 'remarks', 'cost_center_id','applied_date', 'approval_layer_id');
            $requisitionData['status'] = "Pending";

            $requisitionDetailData = array();
            foreach($request->material_id as  $key => $data){
                $requisitionDetailData[] = [
                    'floor_id'      =>  !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'required_date' =>  $request->required_date[$key]
                ];
            }

            DB::transaction(function()use($general_requisition, $requisitionData, $requisitionDetailData){
                $general_requisition->update($requisitionData);
                $general_requisition->requisitiondetails()->delete();
                $general_requisition->requisitiondetails()->createMany($requisitionDetailData);
            });

            return redirect()->route('general-requisitions.index')->with('message', 'Data has been updated successfully');
        }    catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $requisition)
    {
        //
    }

    public function pdf($id)
    {
        $requisitions = Requisition::where('id', $id)->latest()->get();
        $requisitions->load('requisitionDetails.nestedMaterial.boqSupremeBudgets');
        return PDF::loadview('general-requisition.pdf', compact('requisitions'))->setPaper('A4', 'portrait')->stream('requisition.pdf');
    }

    public function generalRequisitionApproved(Requisition $requisition, $status)
    {
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition){
                $q->where('id',$requisition->approval_layer_id);
            })->wheredoesnthave('approvals',function ($q) use($requisition){
                $q->where('approvable_id',$requisition->id)->where('approvable_type',Requisition::class);
            })->orderBy('order_by','asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            $requisition->approval()->create($data);

            return redirect()->route('general-requisitions.index')->with('message', "Requisition No $requisition->mpr_no approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    // public function seed_material()
    //     {
    //         $content = file_get_contents('../storage/additional_materials_by_ranks_obhi_18_05_22.txt');
    //         $items = explode("\n",$content);
    //         foreach ($items as $item) {
    //             $item_details = explode(",", $item);

    //             $unit = $this->switchUnit(trim(str_replace("'","",$item_details[count($item_details)-1])));
    //             $check_parent = array_slice($item_details, 0, 2);
    //             $check_grand_child = array_slice($item_details, 2, 2);
    //             $ff = array();
    //             array_push($ff, $check_parent);
    //             array_push($ff, $check_grand_child);
    //             $parent = null;

    //             foreach($ff as $item){
    //                 foreach($item as $data){
    //                     $trim = trim(str_replace("'","",$data));
    //                     $check = NestedMaterial::where('name', $trim)->first();
    //                     if($check){
    //                         $parent = $check->id;
    //                     }else{
    //                         $insert = NestedMaterial::create([
    //                             'parent_id' => $parent,
    //                             'name'  => $trim,
    //                             'unit_id'  =>  $unit
    //                         ]);
    //                         $parent = $insert->id;

    //                     }
    //                 }
    //             }
    //         }
    //     }

    // public function switchUnit($unit)
    // {
    //     switch($unit){
    //     case 'BAG':
    //         $unit = 2;
    //         break;
    //     case 'PCS':
    //         $unit = 3;
    //         break;
    //     case 'KG':
    //         $unit = 5;
    //         break;
    //     case 'CFT':
    //         $unit = 6;
    //         break;
    //     case 'RFT':
    //         $unit = 8;
    //         break;
    //     case 'SFT':
    //         $unit = 9;
    //         break;
    //     case 'LTR':
    //         $unit = 10;
    //         break;
    //     case 'NOS':
    //         $unit = 11;
    //         break;
    //     case 'NO':
    //         $unit = 12;
    //         break;
    //     case 'PKT':
    //         $unit = 13;
    //         break;
    //     case 'SET':
    //         $unit = 14;
    //         break;
    //     case 'FEET':
    //         $unit = 15;
    //         break;
    //     case 'LBS':
    //         $unit = 16;
    //         break;
    //     case 'MTR':
    //         $unit = 17;
    //         break;
    //     case 'PAIR':
    //         $unit = 18;
    //         break;
    //     case 'YRD':
    //         $unit = 19;
    //         break;
    //     case 'KVA':
    //         $unit = 20;
    //         break;
    //     case 'GALLON':
    //         $unit = 21;
    //         break;
    //     case 'KW':
    //         $unit = 22;
    //         break;
    //     default:
    //         $unit = 0;
    //     }
    //     return $unit;
    // }

}
