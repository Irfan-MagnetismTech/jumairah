<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Boq\Configurations\BoqWork;
use App\Procurement\NestedMaterial;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\BoqEmeLaborRate;
use App\Http\Requests\Boq\Eme\BoqEmeLaborRateRequest;

class BoqElectricalLaborRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-labor-rate-view|boq-eme-labor-rate-create|boq-eme-labor-rate-edit|boq-eme-labor-rate-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-labor-rate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-labor-rate-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-labor-rate-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $utilityBills = BoqEmeLaborRate::orderBy('id', 'DESC')->paginate(15);
        return view('eme.labor_rate.index', compact('utilityBills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $formType = 'create';
        $boq_works        = BoqWork::whereNull('parent_id')->get()->toTree();
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('parent_id', null)->orderBy('id')->pluck('name', 'id');
        return view('eme.labor_rate.create', compact('formType', 'leyer1NestedMaterial', 'boq_works'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqEmeLaborRateRequest $request)
    {
        try {
            $laborrate_data = $request->only('second_layer_parent_id', 'note', 'project_id', 'description', 'basis_of_measurement', 'type', "project_id");
            $laborratedetails_data = [];
            if ($request->type) {
                foreach ($request->work_id as  $key => $data) {
                    $laborratedetails_data[] = [
                        'boq_work_id'          => $request->work_id[$key],
                        'labor_rate'           => $request->work_labor_rate[$key],
                        'qty'                  => $request->work_qty[$key]
                    ];
                }
            } else {
                foreach ($request->material_id as  $key => $data) {
                    $laborratedetails_data[] = [
                        'material_id'          => $request->material_id[$key],
                        'labor_rate'           => $request->labor_rate[$key],
                        'qty'                  => $request->qty[$key]
                    ];
                }
            }
            DB::beginTransaction();
            $boqEmelabor = BoqEmeLaborRate::create($laborrate_data);
            $boqEmelabor->labor_rate_details()->createMany($laborratedetails_data);
            DB::commit();
            return redirect()->route('eme.labor_rate.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
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
    public function edit(BoqEmeLaborRate $labor_rate)
    {
        //
        $formType = 'edit';
        $boq_works  = BoqWork::whereNull('parent_id')->get()->toTree();
        $parent_data = BoqWork::ancestorsOf($labor_rate->labor_rate_details->first()->boq_work_id)->pluck('name', 'id');
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('parent_id', null)->orderBy('id')->pluck('name', 'id');
        $leyer2NestedMaterial = NestedMaterial::with('descendants')->where('parent_id', $labor_rate->NestedMaterialSecondLayer->parent_id)->orderBy('id')->pluck('name', 'id');
        return view('eme.labor_rate.create', compact('formType', 'leyer1NestedMaterial', 'leyer2NestedMaterial', 'labor_rate', 'boq_works', 'parent_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoqEmeLaborRateRequest $request, BoqEmeLaborRate $labor_rate)
    {
        try {
            $laborrate_data = $request->only('second_layer_parent_id', 'note', 'project_id', 'description', 'basis_of_measurement', 'type', 'project_id');
            $laborratedetails_data = [];
            if ($request->type) {
                $laborrate_data['second_layer_parent_id'] = null;
                foreach ($request->work_id as  $key => $data) {
                    $laborratedetails_data[] = [
                        'boq_work_id'          => $request->work_id[$key],
                        'labor_rate'           => $request->work_labor_rate[$key],
                        'qty'                  => $request->work_qty[$key],
                    ];
                }
            } else {
                $laborrate_data['type'] = null;
                foreach ($request->material_id as  $key => $data) {
                    $laborratedetails_data[] = [
                        'material_id'          => $request->material_id[$key],
                        'labor_rate'           => $request->labor_rate[$key],
                        'qty'                  => $request->qty[$key]
                    ];
                }
            }

            DB::beginTransaction();
            $labor_rate->update($laborrate_data);
            $labor_rate->labor_rate_details()->delete();
            $labor_rate->labor_rate_details()->createMany($laborratedetails_data);
            DB::commit();
            return redirect()->route('eme.labor_rate.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoqEmeLaborRate $labor_rate)
    {
        try {
            $labor_rate->delete();
            return redirect()->route('eme.labor_rate.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function Approve($BoqEmeLaborRateId, $status)
    {
        try {
            $BoqEmeLaborRate = BoqEmeLaborRate::findOrFail($BoqEmeLaborRateId);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeLaborRate) {
                $q->where([['name', 'BOQ EME LABOR RATE'], ['department_id', $BoqEmeLaborRate->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeLaborRate) {
                $q->where('approvable_id', $BoqEmeLaborRate->id)
                    ->where('approvable_type', BoqEmeLaborRate::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeLaborRate) {
                $q->where([['name', 'BOQ EME LABOR RATE'], ['department_id', $BoqEmeLaborRate->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeLaborRate) {
                $q->where('approvable_id', $BoqEmeLaborRate->id)
                    ->where('approvable_type', BoqEmeLaborRate::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($BoqEmeLaborRate, $data, $check_approval) {
                $approvalData = $BoqEmeLaborRate->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('eme.labor_rate.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function pdf(BoqEmeLaborRate $labor_rate)
    {
        $labor_rate->load('labor_rate_details');
        // return view('boq.departments.electrical.utility_bill.pdf', compact('BoqEmeUtilityBill'));
        $pdf = \PDF::loadview('eme.labor_rate.pdf', compact('labor_rate'))->setPaper('A4', 'portrait');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.15, "Multiply");

        $canvas->page_text(
            $width / 3,
            $height / 2,
            config('company_info.company_name'),
            null,
            55,
            array(0, 0, 0),
            2,
            2,
            -30
        );
        return $pdf->stream('labor_rate.pdf');
    }
}
