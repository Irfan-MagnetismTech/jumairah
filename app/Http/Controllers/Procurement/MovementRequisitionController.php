<?php

namespace App\Http\Controllers\Procurement;

use App\Approval\Approval;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementRequisitionRequest;
use App\Http\Requests\UpdateMovementRequisitionRequest;
use App\Procurement\MovementRequisition ;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MovementRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movement_requisitions = MovementRequisition::get();
        return view('procurement.movementRequisitions.index', compact('movement_requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.movementRequisitions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMovementRequisitionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovementRequisitionRequest $request)
    {
        try{
            $requisitionData = $request->only('mtrf_no','date', 'delivery_date', 'from_costcenter_id', 'cost_center_id', 'reason','remarks');
            $requisitionData['requested_by']  = auth()->id();
            $requisitionData['from_costcenter_id']  = $request->from_costcenter_id;
            $requisitionData['to_costcenter_id']  = $request->cost_center_id;
            // $requisitionData['status']          = "Pending";

            // dd($request->all());

            $requisitionDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requisitionDetailData[] = [
                    'floor_id'      =>  !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    // 'required_date' =>  $request->required_date[$key]
                ];
            }

            // dd($requisitionData, $requisitionDetailData);
            DB::transaction(function()use($requisitionData, $requisitionDetailData){
                $requisition = MovementRequisition::create($requisitionData);
                $requisition->movementRequisitionDetails()->createMany($requisitionDetailData);
            });

            return redirect()->route('movement-requisitions.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MovementRequisition  $movementRequisition
     * @return \Illuminate\Http\Response
     */
    public function show(MovementRequisition $movementRequisition)
    {
        return view('procurement.movementRequisitions.show',compact('movementRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MovementRequisition  $movementRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit(MovementRequisition $movementRequisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovementRequisitionRequest  $request
     * @param  \App\MovementRequisition  $movementRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovementRequisitionRequest $request, MovementRequisition $movementRequisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MovementRequisition  $movementRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovementRequisition $movementRequisition)
    {
        //
    }

    public function movmentRequisitionApproval(MovementRequisition  $movementRequisitions, $status){
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($movementRequisitions){
                $q->where([['name','Movement Requisition'],['department_id',$movementRequisitions->user->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($movementRequisitions){
                $q->where('approvable_id',$movementRequisitions->id)->where('approvable_type',MovementRequisition::class);
            })->orderBy('order_by','asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            $movementRequisitions->approval()->create($data);

            return redirect()->route('movement-requisitions.index')->with('message', "Requisition No $movementRequisitions->mpr_no approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
