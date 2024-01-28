<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\CsRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Eme\BoqEmeCs;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\BoqEmeCsSupplierEvalField;

class BoqEmeWorkCsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:boq-eme-work-cs-view|boq-eme-work-cs-create|boq-eme-work-cs-edit|boq-eme-work-cs-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:boq-eme-work-cs-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:boq-eme-work-cs-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:boq-eme-work-cs-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cs = BoqEmeCs::latest()->get();
        return view('eme.work-cs.index', compact('cs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $supplier_options = BoqEmeCsSupplierEvalField::get();
        return view('eme.work-cs.create', compact('formType', 'supplier_options'));
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
            DB::beginTransaction();
            $all_details = $this->getAllDetails($request);
            $all_details['all_request']['project_id'] = $request->project_id;
            $cs = BoqEmeCs::create($all_details['all_request']);
            $cs_materials = $cs->csMaterials()->createMany($all_details['cs_materials']);
            $cs_suppliers = $cs->csSuppliers()->createMany($all_details['cs_suppliers']);
            foreach ($cs_suppliers as $key => $value) {
                $value->csSupplierOptions()->createMany($all_details['cs_supplier_options'][$key]);
            }
            $cs->csMaterialsSuppliers()
                ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            DB::commit();
            return redirect()->route('eme.work_cs.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BoqEmeCs $work_c)
    {
        //
        return view('eme.work-cs.show', compact('work_c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BoqEmeCs $work_c)
    {
        $formType = 'edit';
        $supplier_options = BoqEmeCsSupplierEvalField::get();
        return view('eme.work-cs.create', compact('formType', 'supplier_options', 'work_c'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoqEmeCs $work_c)
    {
        try {
            DB::beginTransaction();
            $all_details = $this->getAllDetails($request);
            $work_c->update($all_details['all_request']);
            $work_c->csMaterials()->delete();
            $cs_materials = $work_c->csMaterials()->createMany($all_details['cs_materials']);
            $work_c->csSuppliers()->delete();
            $cs_suppliers = $work_c->csSuppliers()->createMany($all_details['cs_suppliers']);
            foreach ($cs_suppliers as $key => $value) {
                $value->csSupplierOptions()->createMany($all_details['cs_supplier_options'][$key]);
            }
            $work_c->csMaterialsSuppliers()->delete();
            $work_c->csMaterialsSuppliers()
                ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            DB::commit();
            return redirect()->route('eme.work_cs.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoqEmeCs $work_c)
    {
        try {
            $work_c->delete();

            return redirect()->route('eme.work_cs.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    private function getAllDetails($request): array
    {
        foreach (array_keys($request['material_id']) as $material_key) {
            $cs_materials[] = [
                'material_id' => $request['material_id'][$material_key]
            ];
        }

        foreach (array_keys($request['supplier_id']) as $supplier_key) {
            $cs_suppliers[] = [
                'supplier_id'           => $request['supplier_id'][$supplier_key],
                'is_checked'            => in_array($request['supplier_id'][$supplier_key], $request['checked_supplier']) ? true : false,
            ];
        }

        $price_index = 0;
        foreach (array_keys($request['material_id']) as $material_key) {
            foreach (array_keys($request['supplier_id']) as $supplier_key) {
                $cs_materials_suppliers[] = [
                    'material_id' => $request['material_id'][$material_key],
                    'supplier_id' => $request['supplier_id'][$supplier_key],
                    'price'       => $request['price'][$price_index++],
                ];
            }
        }
        foreach ($request['option_id'] as $key1 => $supplier_keys) {
            foreach ($supplier_keys as $key2 => $supplier) {
                $supplier_option[$key2][] = [
                    'boq_eme_cs_supplier_eval_field_id'             => $request['option_id'][$key1][$key2],
                    'value'                                         => $request['option_value'][$key1][$key2],
                ];
            }
        }
        return
            [
                'cs_supplier_options'    => $supplier_option,
                'all_request'            => $request->all(),
                'cs_materials'           => $cs_materials,
                'cs_suppliers'           => $cs_suppliers,
                'cs_materials_suppliers' => $cs_materials_suppliers,
            ];
    }

    private function getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request): array
    {
        $price_index = 0;

        foreach ($cs_materials as $cs_material) {
            foreach ($cs_suppliers as $cs_supplier) {
                $cs_materials_suppliers[] = [
                    'boq_eme_cs_material_id' => $cs_material->id,
                    'boq_eme_cs_supplier_id' => $cs_supplier->id,
                    'price'          => $request['price'][$price_index++],
                ];
            }
        }


        return $cs_materials_suppliers;
    }

    public function Approve($BoqEmeCsId, $status)
    {
        try {
            $BoqEmeCs = BoqEmeCs::findOrFail($BoqEmeCsId);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeCs) {
                $q->where([['name', 'BOQ EME COMPARATIVE STATEMENT'], ['department_id', $BoqEmeCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeCs) {
                $q->where('approvable_id', $BoqEmeCs->id)
                    ->where('approvable_type', BoqEmeCs::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($BoqEmeCs) {
                $q->where([['name', 'BOQ EME COMPARATIVE STATEMENT'], ['department_id', $BoqEmeCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($BoqEmeCs) {
                $q->where('approvable_id', $BoqEmeCs->id)
                    ->where('approvable_type', BoqEmeCs::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($BoqEmeCs, $data, $check_approval) {
                $approvalData = $BoqEmeCs->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('eme.work_cs.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    public function pdf(BoqEmeCs $work_c)
    {
        $BoqEmeCsSupplierEvalField = BoqEmeCsSupplierEvalField::get();
        $work_c->load('csMaterials', 'csSuppliers', 'csMaterialsSuppliers');
        $pdf = \PDF::loadview('eme.work-cs.pdf', compact('work_c', 'BoqEmeCsSupplierEvalField'))->setPaper('A4', 'portrait');
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
            39,
            array(0, 0, 0),
            2,
            2,
            -30
        );
        return $pdf->stream('work_c.pdf');
    }
}
