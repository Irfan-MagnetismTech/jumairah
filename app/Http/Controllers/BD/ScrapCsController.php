<?php

namespace App\Http\Controllers\BD;

use App\Approval\ApprovalLayerDetails;
use App\BD\ScrapCs;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\ScrapCsRequest;
use App\Procurement\NestedMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\BD\ScrapCsMaterialSupplier;

class ScrapCsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-scrap-cs-view|bd-scrap-cs-create|bd-scrap-cs-edit|bd-scrap-cs-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-scrap-cs-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-scrap-cs-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-scrap-cs-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ScrapCs = ScrapCs::latest()->get();

        return view('bd.scrap-cs.index', compact('ScrapCs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form_type = 'Add';

        $Taxes = [
            'Include','Exclude'
        ];

        $payment_type = [
            'cash',
            'cheque'
        ];
        $all_materials = NestedMaterial::with(['unit'])->get();

        return view('bd.scrap-cs.create', compact('form_type', 'all_materials','Taxes','payment_type'));
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
            $all_details = $this->getAllDetails($request);
            DB::transaction(function () use ($all_details, $request)
            {
                $cs= ScrapCs::create($all_details['all_request']);
                $cs_materials = $cs->ScrapcsMaterials()->createMany($all_details['cs_materials']);
                $cs_suppliers = $cs->ScrapcsSuppliers()->createMany($all_details['cs_suppliers']);
                $cs->ScrapcsMaterialsSuppliers()
                    ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            });

            return redirect()->route('scrapCs.index')->with('message', 'Comparative Statement created');

        }
        catch (QueryException $e)
        {
            return redirect()->route('scrapCs.create')->withErrors($e->getMessage());
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
    public function edit($id)
    {
       $scrapCs = ScrapCs::findOrFail($id);
        $form_type = 'edit';

        $Taxes = [
            'Include','Exclude'
        ];

        $payment_type = [
            'cash',
            'cheque'
        ];
        $all_materials = NestedMaterial::with(['unit'])->get();
        return view('bd.scrap-cs.create', compact('form_type', 'all_materials','Taxes','payment_type','scrapCs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $scrapCs = ScrapCs::findOrFail($id);
            $all_details = $this->getAllDetails($request);

            DB::transaction(function () use ($scrapCs, $all_details, $request)
            {
                $scrapCs->update($all_details['all_request']);

                $scrapCs->ScrapcsMaterials()->delete();
                $cs_materials = $scrapCs->ScrapcsMaterials()->createMany($all_details['cs_materials']);

                $scrapCs->ScrapcsSuppliers()->delete();
                $cs_suppliers = $scrapCs->ScrapcsSuppliers()->createMany($all_details['cs_suppliers']);

                $scrapCs->ScrapcsMaterialsSuppliers()->delete();
                $scrapCs->ScrapcsMaterialsSuppliers()
                    ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            });

            return redirect()->route('scrapCs.index')->with('message', 'Comparative Statement updated');

        }
        catch (QueryException $e){
            return redirect()->route('scrapCs.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $scrap_Cs = ScrapCs::findOrFail($id);
            $scrap_Cs->delete();
            return redirect()->route('scrapCs.index')->with('message', 'Comparative Statement deleted');
        }catch (QueryException $e){
            return redirect()->route('scrapCs.create')->withErrors($e->getMessage());
        }
    }

    /**
     * @param ScrapCs $comparative_statement
     */
    public function pdf($scrapCs_id,$scrap_cs_supplier_id)
    {
       $ScrapCsMaterialSupplier = ScrapCsMaterialSupplier::where('scrap_cs_id',$scrapCs_id)->where('scrap_cs_supplier_id',$scrap_cs_supplier_id)->get();
        return \PDF::loadview('bd.scrap-cs.pdf', compact('ScrapCsMaterialSupplier'))->setPaper('a4', 'portrait')->stream('scrap-cs.pdf');
    }


    private function getAllDetails($request)
    {
        foreach (array_keys($request['material_id']) as $material_key)
        {
            $cs_materials[] = [
                'material_id' => $request['material_id'][$material_key],
                'scrap_form_id' => $request['scrap_form_id'][$material_key]
            ];
        }

        foreach (array_keys($request['supplier_id']) as $supplier_key)
        {
            $cs_suppliers[] = [
                'supplier_id'           => $request['supplier_id'][$supplier_key],
                'vat_tax'               => $request['vat_tax'][$supplier_key],
                'security_money'        => $request['security_money'][$supplier_key],
                'payment_type'          => $request['payment_type'][$supplier_key],
                'lead_time'             => $request['lead_time'][$supplier_key],
                'is_checked'            => in_array($request['supplier_id'][$supplier_key], $request['checked_supplier']) ? true : false,
            ];
        }

        $price_index = 0;
        foreach (array_keys($request['material_id']) as $material_key)
        {
            foreach (array_keys($request['supplier_id']) as $supplier_key)
            {
                $cs_materials_suppliers[] = [
                    'material_id' => $request['material_id'][$material_key],
                    'supplier_id' => $request['supplier_id'][$supplier_key],
                    'price'       => $request['price'][$price_index++],
                ];
            }
        }

        return
            [
            'all_request'            => $request->all(),
            'cs_materials'           => $cs_materials,
            'cs_suppliers'           => $cs_suppliers,
            'cs_materials_suppliers' => $cs_materials_suppliers,
        ];
    }

    /**
     * @param array $cs_materials
     * @param array $cs_suppliers
     * @param array $request
     * @return array
     */
    private function getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request): array
    {
        $price_index = 0;

        foreach ($cs_materials as $cs_material)
        {
            foreach ($cs_suppliers as $cs_supplier)
            {
                $cs_materials_suppliers[] = [
                    'scrap_cs_material_id' => $cs_material->id,
                    'scrap_cs_supplier_id' => $cs_supplier->id,
                    'price'          => $request['price'][$price_index++],
                ];
            }
        }

        return $cs_materials_suppliers;
    }

    public function Approved($id,$status)
    {
        try {
            DB::beginTransaction();
            $scrapCs = ScrapCs::findOrFail($id);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapCs) {
                $q->where([['name', 'SCRAP CS'], ['department_id', $scrapCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapCs) {
                $q->where('approvable_id', $scrapCs->id)
                    ->where('approvable_type', ScrapCs::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapCs) {
                $q->where([['name', 'SCRAP CS'], ['department_id', $scrapCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapCs) {
                $q->where('approvable_id', $scrapCs->id)
                    ->where('approvable_type', ScrapCs::class);
            })->orderBy('order_by', 'desc')->first();
                $approvalData = $scrapCs->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
               
            }
            return redirect()->route('scrapCs.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        

    }
}
