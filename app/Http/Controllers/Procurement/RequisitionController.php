<?php

namespace App\Http\Controllers\Procurement;

use App\Approval\ApprovalLayer;
use App\Approval\ApprovalLayerDetails;
use App\Employee;
use App\RequisitionApproved;

use Illuminate\Http\Request;
use App\Procurement\Material;
use App\Procurement\Requisition;
use Illuminate\Support\Facades\DB;
use App\Procurement\MaterialBudget;
use App\Procurement\NestedMaterial;
use App\Http\Controllers\Controller;
use App\Procurement\Requisitiondetails;
use Illuminate\Database\QueryException;
use App\Http\Requests\RequisitionRequest;
use App\Procurement\BoqSupremeBudget;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CommonNotification;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:requisition-view|requisition-create|requisition-edit|requisition-delete', ['only' => ['index', 'show', 'pdf', 'requisitionApproved']]);
        $this->middleware('permission:requisition-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:requisition-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:requisition-delete', ['only' => ['destroy']]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitions = Requisition::whereNull('condition')->latest()->get();
        return view('procurement.requisitions.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->isAdmin()) {
            $ApprovalLayerName = ApprovalLayer::where('name', 'like', 'Requisition%')->pluck('name', 'id');
        } else {
            $ApprovalLayerName = ApprovalLayer::where('name', 'like', 'Requisition%')->where('department_id', auth()->user()?->department?->id)->pluck('name', 'id');
        }
        $formType     = "create";

        return view('procurement.requisitions.create', compact('formType', 'ApprovalLayerName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisitionRequest $request)
    {
        //dd($request->all());
        try{
            $requisitionData = $request->only('mpr_no', 'cost_center_id', 'applied_date', 'note', 'remarks','approval_layer_id');
            $requisitionData['requisition_by']  = auth()->id();
            $requisitionData['status']          = "Pending";
            $requisitionDetailData = array();
            foreach ($request->material_id as  $key => $data) {

                $requisitionDetailData[] = [
                    'floor_id'      =>  !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'required_date' =>  $request->required_date[$key],
                    'project_id'    =>  $request->project_id,
                ];
            }

            DB::transaction(function () use ($requisitionData, $requisitionDetailData) {
                $requisition = Requisition::create($requisitionData);
                $requisition->requisitiondetails()->createMany($requisitionDetailData);
                $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition) {
                    $q->where('id', $requisition->approval_layer_id);
                })->whereDoesntHave('approvals', function ($q) use ($requisition) {
                    $q->where('approvable_id', $requisition->id)->where('approvable_type', Requisition::class);
                })->orderBy('order_by', 'asc')->first();
                // $employees = Employee::query()->where('department_id',$approval->department_id)->where('designation_id',$approval->designation_id)->get();
                // $messageData = [
                //     'messege'=>'requsition is created and waiting for your approval'
                // ];
                // foreach($employees as $employee){
                //     $employee->user->notify(new CommonNotification($messageData));
                // }
                //    $userSchema->first()->notify(new CommonNotification($offerData));
            });

            return redirect()->route('requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        return view('procurement.requisitions.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        $formType = "edit";
        if (auth()->user()->isAdmin()) {
            $ApprovalLayerName = ApprovalLayer::where('name', 'like', 'Requisition%')->pluck('name', 'id');
        } else {
            $ApprovalLayerName = ApprovalLayer::where('name', 'like', 'Requisition%')->where('department_id', auth()->user()?->department?->id)->pluck('name', 'id');
        }
        $requisition->load('requisitionDetails.nestedMaterial.boqSupremeBudgets');
        return view('procurement.requisitions.create', compact('requisition', 'formType', 'ApprovalLayerName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(RequisitionRequest $request, Requisition $requisition)
    {
        try {
            $requisitionData = $request->only('note', 'remarks', 'cost_center_id', 'applied_date', 'approval_layer_id');
            $requisitionData['status'] = "Pending";

            $requisitionDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $requisitionDetailData[] = [
                    'floor_id'      =>  !empty($request->floor_id[$key]) ? $request->floor_id[$key] : null,
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'required_date' =>  $request->required_date[$key],
                    'project_id'    =>  $request->project_id,
                ];
            }

            DB::transaction(function () use ($requisition, $requisitionData, $requisitionDetailData) {
                $requisition->update($requisitionData);
                $requisition->requisitiondetails()->delete();
                $requisition->requisitiondetails()->createMany($requisitionDetailData);
            });

            return redirect()->route('requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $requisition)
    {
        try {
            $requisition->delete();
            return redirect()->route('requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('requisitions.index')->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $requisitions = Requisition::where('id', $id)->latest()->get();
        $requisitions->load('requisitionDetails.nestedMaterial.boqSupremeBudgets');
        return \PDF::loadview('procurement.requisitions.pdf', compact('requisitions'))->setPaper('A4', 'portrait')->stream('requisition.pdf');
    }

    public function requisitionApproved(Requisition $requisition, $status)
    {
        try {
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($requisition) {
                $q->where('id', $requisition->approval_layer_id);
            })->whereDoesntHave('approvals', function ($q) use ($requisition) {
                $q->where('approvable_id', $requisition->id)->where('approvable_type', Requisition::class);
            })->orderBy('order_by', 'asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            $requisition->approval()->create($data);

            return redirect()->route('requisitions.index')->with('message', "Requisition No $requisition->mpr_no approved.");
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
