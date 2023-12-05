<?php

namespace App\Http\Controllers\Approval;

use App\Approval\ApprovalLayer;
use App\Department;
use App\Designation;
use App\Config\LeayerName;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalLayerRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approval_leyar_data = ApprovalLayer::latest()->get();

        return view('approval-layer.index', compact('approval_leyar_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $layers   = LeayerName::orderBy('name')->select('name')->get();
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $designations = Designation::orderBy('name')->pluck('name', 'id');

        return view('approval-layer.create', compact('formType', 'designations','departments', 'layers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $approvalLayerData = $request->only('name');
            $approvalLayerData['department_id'] = $request->for_department_id;
            $approvalLayerDetailData = [];

            DB::transaction(function () use ($approvalLayerData, $approvalLayerDetailData, $request)
            {
                $approvalLayer = ApprovalLayer::create($approvalLayerData);
                foreach ($request->designation_id as $key => $data)
                {
                    $approvalLayerDetailData[] = [
                        'department_id' => $request->department_id[$key],
                        'designation_id' => $request->designation_id[$key],
                        'name'          => $request->layer_name[$key],
                        'order_by'       => $request->order_by[$key],
                        'layer_key'      => $approvalLayer->id . '_' . $request->department_id[$key] . '_' . $request->designation_id[$key],
                    ];
                }
                $approvalLayer->approvalLeyarDetails()->createMany($approvalLayerDetailData);
            });

            return redirect()->route('approval-layer.index')->with('message', 'Data has been inserted successfully');
        }
        catch (QueryException $e)
        {
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
    public function edit(ApprovalLayer $approvalLayer)
    {
        //
        $formType = 'edit';
        $layers   = LeayerName::orderBy('name')->select('name')->get();
        $departments = Department::orderBy('name')->pluck('name', 'id');
        return view('approval-layer.create', compact('formType', 'departments','approvalLayer', 'layers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApprovalLayerRequest $request, ApprovalLayer $approvalLayer)
    {
        try {
            $approvalLayerData = $request->only('name');
            $approvalLayerData['department_id'] = $request->for_department_id;
            $approvalLayerDetailData = [];
            foreach ($request->designation_id as $key => $data)
            {
                $approvalLayerDetailData[] = [
                    'department_id'  => $request->department_id[$key],
                    'designation_id' => $request->designation_id[$key],
                    'name'           => $request->layer_name[$key],
                    'order_by'       => $request->order_by[$key],
                    'layer_key'      => $approvalLayer->id . '_' . $request->department_id[$key] . '_' . $request->designation_id[$key],
                ];
            }

            DB::transaction(function () use ($approvalLayer, $approvalLayerData, $approvalLayerDetailData)
            {
                $approvalLayer->update($approvalLayerData);
                $approvalLayer->approvalLeyarDetails()->delete();
                $approvalLayer->approvalLeyarDetails()->createMany($approvalLayerDetailData);
            });

            return redirect()->route('approval-layer.index')->with('message', 'Data has been updated successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalLayer $approvalLayer)
    {
        try {
            DB::transaction(function () use ($approvalLayer)
            {
                $approvalLayer->delete();
            });

            return redirect()->route('approval-layer.index')->with('message', 'Data has been Deleted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
