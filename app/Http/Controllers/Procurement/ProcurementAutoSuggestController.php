<?php

namespace App\Http\Controllers\Procurement;

use App\Boq\Configurations\BoqWork;
use App\Construction\ScopeWorks;
use App\CostCenter;
use App\CSD\CsdMaterial;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Procurement\Cs;
use App\Procurement\CsMaterial;
use App\Procurement\CsProject;
use App\Procurement\CsSupplier;
use App\Procurement\Iou;
use App\Procurement\Material;
use App\Procurement\MaterialBudget;
use App\Procurement\Materialbudgetdetail;
use App\Procurement\MaterialReceive;
use App\Procurement\Materialreceiveddetail;
use App\Procurement\NestedMaterial;
use App\Procurement\PurchaseOrder as ProcurementPurchaseOrder;
use App\Procurement\PurchaseOrderDetail;
use App\Procurement\Requisition;
use App\Procurement\Requisitiondetails;
use App\Procurement\Supplier;

use App\Procurement\PurchaseOrder;
use App\Procurement\Supplierbillmprdetails;
use App\Project;
use App\Sells\Client;
use App\Stockout;
use Illuminate\Http\Request;

class ProcurementAutoSuggestController extends Controller
{


    /**
     * @param Request $request
     */
    public function csdMaterialAutoSuggestWithRate(Request $request)
    {
        $search = $request->search;

            $items = CsdMaterial::with('materialRate')->where('name', 'LIKE', "%$search%")->get();

        $response = [];
        foreach ($items as $item)
        {
            $response[] = [
                'label' => $item->name,
                'value' => $item->name,
                'material_id' => $item->id,
                'unit_name' => $item->unit->name,
                'unit_id' => $item->unit->id,
                'demand_rate'=> $item->materialRate->demand_rate,
                'refund_rate'=> $item->materialRate->refund_rate
            ];
        }

        return response()->json($response);
    }


    /**
     * @param Request $request
     */
    public function csdMaterialAutoSuggest(Request $request)
    {
        $search = $request->search;

            $items = CsdMaterial::where('name', 'LIKE', "%$search%")->get();

        $response = [];
        foreach ($items as $item)
        {
            $response[] = [
                'label' => $item->name,
                'value' => $item->name,
                'material_id' => $item->id,
                'unit_name' => $item->unit->name,
                'unit_id' => $item->unit->id
            ];
        }

        return response()->json($response);
    }



    /**
     * @param Request $request
     */
    public function materialAutoSuggest(Request $request)
    {
        $search = $request->search;
            $items = NestedMaterial::where('name', 'LIKE', "%$search%")->get();
        $response = [];
        foreach ($items as $item)
        {
            $response[] = ['label' => $item->name, 'value' => $item->name, 'material_id' => $item->id, 'unit' => $item->unit];
        }

        return response()->json($response);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function loadBOQbudgetedMaterialsDropdown(Request $request)
    {

        $search     = $request->search;
        $project_id = $request->project_id;
        $materials  = [];

        $budget_materials = MaterialBudget::with('nestedMaterial.unit')
            ->where('project_id', $project_id)
            ->get();

        foreach ($budget_materials as $key => $value)
        {
            $budget_materials[$key]['label'] = $value->nestedMaterial->name;
            $budget_materials[$key]['unit']  = $value->nestedMaterial->unit->name;
            $budget_materials[$key]['unit_id']  = $value->nestedMaterial->unit->id;
        }

        return response()->json($budget_materials);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function budgetedmaterialAutoSuggest(Request $request)
    {

        $search     = $request->search;
        $project_id = $request->project_id;
        $materials  = [];

        $materials = NestedMaterial::
                whereHas('materialbudgets.project', fn ($query) => $query->where('id', $project_id))
                ->where('name', 'LIKE', "%${search}%")
                ->get()
                ->pluck('id');

        $budget_materials = MaterialBudget::with('nestedMaterial.unit')
            ->where('project_id', $project_id)
            ->where('material_id', $materials)
            ->get();

        foreach ($budget_materials as $key => $value)
        {
            $budget_materials[$key]['label'] = $value->nestedMaterial->name;
            $budget_materials[$key]['unit']  = $value->nestedMaterial->unit->name;
            $budget_materials[$key]['unit_id']  = $value->nestedMaterial->unit->id;
        }

        return response()->json($budget_materials);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadMrr(Request $request)
    {
        $search = $request->search;
        $items = MaterialReceive::
        where('mrr_no', 'LIKE', "%${search}%")
        ->get(['id', 'mrr_no'])
        ->map(fn($item) => ['value' => $item->id, 'label' => $item->mrr_no]);;

        return response()->json($items);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadboqWorkHead(Request $request)
    {
        $search = $request->search;
        $items = BoqWork::
        where('name', 'LIKE', "%${search}%")
        ->get(['id', 'name'])
        ->map(fn($item) => ['value' => $item->id, 'label' => $item->name]);

        return response()->json($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadmaterialName(Request $request)
    {

        $search = $request->search;
        $data = NestedMaterial::withDepth()
        // ->having('depth', '=', 3)
        ->where('name', 'LIKE', "%${search}%")
        ->get(['id', 'name', 'unit_id'])
        ->map(fn($item) => ['label' => $item->name, 'value' => $item->id, 'unit' => $item->unit->name, 'unit_id' => $item->unit->id]);

        return response()->json($data);
    }





    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadPoMprSupplierByMrr($mrr_no)
    {
        $items = MaterialReceive::with('purchaseorderForPo.supplier', 'purchaseorderForPo.mpr')
        ->where('mrr_no', $mrr_no)
        ->first();

        $mrr_total = 0;
        foreach ($items->materialreceivedetails as $receiveDetail){
            $po_details = PurchaseOrderDetail::where('material_id', $receiveDetail->material_id)
            ->whereHas('purchaseorder', function ($q) use($items){
                $q->where('po_no', $items->po_no);
            })->first('discount_price');
            $unitePrice = $receiveDetail->quantity * $po_details->discount_price;
            $mrr_total += $unitePrice;
//            dump($receiveDetail->quantity, $po_details->discount_price);
        }

        // $mrrDetails = $items->materialreceivedetails
//         dd($items->po_no, $mrr_total);
        return [$items, 'amount' => $mrr_total];
    }

    /**
     * @param Request $request
     */
    public function getRequisionDetailsByProjectAndMaterial(Request $request)
    {
        $project_id      = $request->project_id;
        $material_id     = $request->material_id;
        $requisition_sum = 0;

        if ($project_id && $material_id)
        {
            $requisition_sum = Materialreceiveddetail::with('materialreceive')
                ->whereHas('materialreceive', function ($query) use ($project_id)
            {
                $query->where('project_id', $project_id);
            })
            ->where('material_id', $material_id)
            ->get()
            ->sum('quantity');
        }

        return response()->json([
            'requisition_sum' => $requisition_sum,
        ]);
    }

    /**
     * @param Request $request
     */
    public function supplierAutoSuggest(Request $request)
    {
        $search = $request->search;
            $items = Supplier::where('name', 'like', '%' . $search . '%')->limit(10)->get();

        $response = [];
        foreach ($items as $item)
        {
            $response[] = [
                'label' => $item->name,
                 'value' => $item->id,
                 'address' => $item->address,
                 'contact' => $item->contact,
                 'account_id' => $item->supplier->account->id ?? 0,
            ];
        }

        return response()->json($response);
    }




    /**
     * @param Request $request
     */
    public function csAutoSuggest(Request $request)
    {

        $search = $request->search;

        $items = Cs::where('reference_no', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id', 'reference_no'])
            ->map(fn($item) => ['label' => $item->reference_no, 'value' => $item->id]);

        return response()->json($items);
    }

    /**
     * @param Request $request
     */
    public function poAutoSuggest(Request $request)
    {
        $search = $request->search;
        if ($search == '')
        {
            $items = \App\Procurement\PurchaseOrder::limit(5)->get(['id', 'date']);
        }
        else
        {
            $items = \App\Procurement\PurchaseOrder::where('id', 'like', '%' . $search . '%')->limit(10)->get(['id', 'date']);
        }
        $response = [];
        foreach ($items as $item)
        {
//            $response[] = array("value"=>$item->id);
            $response[] = ['value' => $item->id, 'date' => $item->date];
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function loadMPRWisePo($mpr_id)
    {
        return $PoList = PurchaseOrder::where('mpr_no', $mpr_id)->orderBy('id')->get();
    }



    /**
     * @param Request $request
     */
    public function getAddressByClient($sell_id)
    {
        return Client::
            where('id', $sell_id)
            ->first();
    }


    /**
     * @param Request $request
     */
    public function getCSReferrenceByPoNo($po_no)
    {
        return PurchaseOrder::with('cs')
            ->where('po_no', $po_no)
            ->get();
    }

    /**
     * @param $po_no
     * @return mixed
     */
    public function loadMprMaterialByPoNo($po_no)
    {
         $items = PurchaseOrder::with('purchaseOrderDetails.nestedMaterials')
        ->where('po_no', $po_no)
        ->first();
        return response()->json($items);
    }

    /**
     * @param $mpr_id
     * @return mixed
     */
    public function loadMprMaterialByMprNo($mpr_id)
    {

        $items = Requisitiondetails::with('nestedMaterial.unit')
            ->orderBy('id')
            ->where('requisition_id', $mpr_id)
            ->get();
        return response()->json($items);
    }



    /**
     * @param $material_id
     * @param $mpr_no
     * @return mixed
     */
    public function loadmaterialDetailsByPoNo($material_id, $po_no)
    {
        $items = PurchaseOrder::with('purchaseOrderDetails.nestedMaterials.unit')
        ->whereHas('purchaseOrderDetails', function ($query) use ($material_id) {
            $query->where('material_id', $material_id);
        })
        ->where('po_no', $po_no)
        ->get();

        return response()->json($items);
    }

    public function getmaterialDetailsByPoNo($material_id, $po_no)
    {
        $items = PurchaseOrderDetail::with('nestedMaterials.unit')->where(['purchase_order_id'=> $po_no, 'material_id' => $material_id])
        ->first();

        return response()->json($items);
    }



    /**
     * @param Request $request
     */
    public function projectAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = Project::
            where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id','name'])
            ->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->name
            ]);

        return response()->json($items);

    }




    /**
     * @param Request $request
     */
    public function MprByPoAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = Requisition::with('purchaseOrder')
            ->where('mpr_no', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id','mpr_no', 'project_id'])
            ->map(fn($item) => [
                'mpr_id'        => $item->id,
                'value'         => $item->mpr_no,
                'project_id'    => $item->project_id,
                'project_name'  => $item->project->name,
                'po_no'         => $item->purchaseOrder->po_no,
                'date'          => $item->purchaseOrder->date,
                'cs_no'         => $item->purchaseOrder->cs->reference_no,
                'po_id'         => $item->purchaseOrder->id
            ]);

        return response()->json($items);

    }


    /**
     * @param Request $request
     */
    public function iouAutoSuggest(Request $request)
    {
        $search = $request->search;
        if ($search == '')
        {
            $items = Iou::limit(5)->get(['id', 'total_amount', 'mpr_no']);
        }
        else
        {
            $items = Iou::where('id', 'like', '%' . $search . '%')->limit(10)->get(['id', 'total_amount', 'mpr_no']);
        }
        $response = [];
        foreach ($items as $item)
        {
            $response[] = ['value' => $item->id, 'total_amount' => $item->total_amount, 'mpr_no' => $item->mpr_no, 'project_name' => $item->mpr->project->name];
        }

        return response()->json($response);
    }

    /**
     * @param $cs_id
     * @return mixed
     */
    public function loadCsSupplier($cs_id)
    {
        return CsSupplier::with('supplier')
            ->where('cs_id', $cs_id)
            ->where('is_checked', true)
            ->get();
    }

    /**
     * @param $po_id
     * @return mixed
     */
    public function loadposupplier(Request $request)
    {

        $search = $request->search;
         $items = PurchaseOrder::with('cssupplier.supplier')
            ->where('po_no', 'like', '%' . $search . '%')
            ->orderBy('id')
            ->limit(10)
            ->get()
            ->map(fn($item) => [ 'label' => $item->po_no, 'value' => $item->cssupplier->supplier->name]);

        return $items;
    }

    /**
     * @param $cs_id
     * @return mixed
     */
    public function loadCsProject($cs_id)
    {
        return CsProject::with('project')
            ->orderBy('id')
            ->where('cs_id', $cs_id)
            ->get();
    }

    /**
     * @param $cs_id
     * @return mixed
     */
    public function loadCsMaterial($cs_id)
    {
        return $materials = CsMaterial::with('material')->orderBy('id')->where('cs_id', $cs_id)->get();
    }

    /**
     * @param $mpr_id
     * @return mixed
     */
    public function loadMprMaterial($mpr_id, $cs_id)
    {
        $materials = CsMaterial::where('cs_id',  $cs_id)
            ->get()
            ->pluck('material_id');

            // dd($materials);

        return Requisitiondetails::with('nestedMaterial.unit')
            ->orderBy('id')
            ->where('requisition_id', $mpr_id)
            ->whereIn('material_id', $materials)
            ->groupBy('material_id')
            ->get();
    }


    public function loadIouMaterials($mpr_no)
    {
        $purchase_order_materials = PurchaseOrderDetail::whereHas('purchaseOrder', function ($query) use ($mpr_no) {
            $query->where('mpr_no', $mpr_no);
        })
        ->get()
        ->pluck('material_id');

        $items = Requisitiondetails::with('nestedMaterial')
        ->whereHas('requisition', function ($query) use ($mpr_no) {
            return $query->where('id', $mpr_no);
        })
        ->whereNotIn('material_id', $purchase_order_materials)
        ->get()
        ->map(fn ($item) => ['label' => $item->nestedMaterial->name, 'value'  => $item->material_id]);
        return response()->json($items);
    }

    public function getIOUMaterialDetails($mpr_no, $material_id)
    {
        return Requisitiondetails::with('nestedMaterial.unit')->where('requisition_id', $mpr_no)
            ->where('material_id', $material_id)
            ->firstOrFail();
    }

    /**
     * @param $material_id
     * @param $mpr_no
     * @return mixed
     */
    public function loadrequisitionmaterial($material_id, $mpr_no)
    {
        return Requisitiondetails::with('nestedMaterial.unit')
            ->orderBy('id')
            ->where('material_id', $material_id)
            ->where('requisition_id', $mpr_no)
            ->firstOrFail();
    }



    /**
     * @param $mrr_no
     * @return mixed
     */
    public function loadmrramount($mrr_no)
    {
        return $materials = MaterialReceive::orderBy('id')->where('id', $mrr_no)->firstOrFail();
    }

    /**
     * @param $material_id
     * @param $po_id
     * @return mixed
     */
    public function loadpobasedmaterial($material_id, $po_id)
    {
        return $materials = PurchaseOrderDetail::with('nestedMaterials.unit')->orderBy('id')->where('material_id', $material_id)->where('purchase_order_id', $po_id)->firstOrFail();
    }

    /**
     * @param $mpr_id
     * @return mixed
     */
    public function loadMprAmount($mpr_id)
    {
        return $amounts = Iou::with('mpr')->orderBy('id')->where('mpr_no', $mpr_id)->first();
    }

    /**
     * @param $po_id
     * @return mixed
     */
    public function loadPoMaterial($po_id)
    {
        return $materials = PurchaseOrderDetail::with('nestedMaterials')->orderBy('id')->where('purchase_order_id', $po_id)->get();
    }



    /**
     * @param Request $request
     */

    public function mprAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = Requisition::where('mpr_no', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id', 'mpr_no', 'applied_date', 'project_id'])
            ->map(fn($item) => ['value' => $item->id, 'label' => $item->mpr_no, 'date' => $item->applied_date, 'project_id' => $item->project->name, 'po_project_id' => $item->project_id]);

        return response()->json($items);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getSupplier($type)
    {
        $supplier = Supplier::orderBy('name')->where('type', $type)->get(['name', 'id']);

        return $supplier;
    }

    /**
     * @param $po_id
     * @return mixed
     */
    public function getPurchaseOrder($po_id)
    {
        return $data = PurchaseOrder::with('purchaseOrderDetails.rowMetarials', 'purchaseOrderDetails.unit', 'supplier', 'purchaseOrderDetails.purchaseDetails')
            ->where('id', $po_id)->firstOrFail();
    }

    /**
     * @param $so_id
     * @return mixed
     */
    public function getStockOutDetail($so_id)
    {
        return $data = Stockout::with('supplier', 'warehouse', 'stockoutdetails.rawMaterial.unit', 'stockoutdetails.stockReternDetails')
            ->where('id', $so_id)->firstOrFail();
    }

}
