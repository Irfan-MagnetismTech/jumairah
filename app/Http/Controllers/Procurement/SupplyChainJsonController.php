<?php

namespace App\Http\Controllers\Procurement;

use App\BD\Source;
use App\BD\ScrapCs;
use App\CostCenter;
use App\Designation;
use App\BD\ScrapForm;
use App\BillRegister;
use App\Procurement\Cs;
use App\Procurement\Iou;
use App\Accounts\Account;
use App\BD\BdFeasiRncCal;
use App\BD\ProjectLayout;
use App\Approval\Approval;
use App\BD\BdFeasiUtility;
use App\BD\ScrapFormDetail;
use App\Accounts\FixedAsset;
use App\BD\BdFeasRncPercent;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use App\BD\BdFeasiPerticular;
use App\BD\BdFeasi_perticular;
use App\BD\BdFeasibilityEntry;
use App\BD\BdFeasiFessAndCost;
use App\Approval\ApprovalLayer;
use App\BD\BdFeasibilityCtc;
use App\BD\BdFesiReferenceFess;
use App\Procurement\CsMaterial;
use App\Procurement\CsSupplier;
use App\Procurement\Storeissue;
use App\BD\BdFeasiFinanceDetail;
use App\Procurement\Requisition;
use App\BD\BdFeasibilityFarChart;
use App\BD\BdFeasiCtcDetail;
use App\Procurement\StockHistory;
use App\BD\BdFeasRncPercentDetail;
use App\Procurement\PurchaseOrder;
use App\BD\BdLeadGenerationDetails;
use App\BD\ScrapCsMaterialSupplier;
use App\Procurement\NestedMaterial;
use App\Procurement\PurchaseDetail;
use App\BD\BdFeasiFessAndCostDetail;
use App\BD\BdFeasiRevenue;
use App\Boq\Configurations\BoqFloor;
use App\Http\Controllers\Controller;
use App\Procurement\MaterialReceive;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\AdvanceAdjustment;
use App\Procurement\Storeissuedetails;
use App\Boq\Departments\Eme\BoqEmeRate;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\CsMaterialSupplier;
use App\Procurement\Requisitiondetails;
use App\Procurement\PurchaseOrderDetail;
use App\Procurement\Materialreceiveddetail;
use App\Procurement\MovementRequisitionDetail;
use Facade\Ignition\DumpRecorder\Dump;
use App\Services\BdFeasiInflowOutflow;

class SupplyChainJsonController extends Controller
{
    private $InflowAndOutflowService;

    function __construct()
    {
        $this->InflowAndOutflowService = new BdFeasiInflowOutflow();
    }

    public function projectAutoSuggest(Request $request)
    {
        $search = $request->search;
        $boq_supreme_budgets = BoqSupremeBudget::get()->pluck('project_id');
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->whereNotNull('project_id')
            ->whereIn('project_id', $boq_supreme_budgets)
            ->limit(5)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }
    public function costCenterAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }

    public function bdProgressBudgetProjectAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id', 'name'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }

    public function bdFutureBudgetProjectAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = BdLeadGeneration::where('land_location', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id', 'land_location'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->land_location
            ]);

        return response()->json($items);
    }

    public function loadProjectWiseFloor($project_id)
    {
        $items = BoqSupremeBudget::with('boqFloorProject.floor')
            ->where('project_id', $project_id)
            ->whereNotNull('floor_id')
            ->groupBy('floor_id')
            ->orderBy('floor_id', 'desc')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->boqFloorProject->floor->name,
                'value'  => $item->boqFloorProject->floor->id
            ]);
        return response()->json($items);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function floorswiseBOQbudgetedMaterials(Request $request)
    {
        $search     = $request->search;
        $project_id = $request->project_id;
        $floor_name   = $request->floor_name;

        $boq_floor_id = BoqSupremeBudget::wherehas('boqFloorProject.floor', fn ($query) => $query->where('id', $floor_name))
            ->where('project_id', $project_id)
            ->first();

        $nested_material_id = NestedMaterial::where('name', 'LIKE', "%${search}%")
            ->first();

        $descendant_nested_materials = NestedMaterial::descendantsAndSelf($nested_material_id->id)
            ->pluck('id')->toArray();


        $budget_materials = BoqSupremeBudget::with('nestedMaterial')
            ->where('project_id', $project_id)
            ->where('floor_id', $boq_floor_id->floor_id)
            ->whereIn('material_id', $descendant_nested_materials)
            ->first();

        $materials_through_boq_budgets = NestedMaterial::with('unit')->descendantsAndSelf($budget_materials->material_id);

        foreach ($materials_through_boq_budgets as $key => $value) {
            $materials_through_boq_budgets[$key]['label']           = $value->name;
            $materials_through_boq_budgets[$key]['material_id']     = $value->id;
            $materials_through_boq_budgets[$key]['unit']            = $value->unit->name;
            $materials_through_boq_budgets[$key]['unit_id']         = $value->unit_id;
            $materials_through_boq_budgets[$key]['quantity']        = $budget_materials->quantity;
            $materials_through_boq_budgets[$key]['material_list']   = $materials_through_boq_budgets->pluck('id')->toArray();
        }

        return response()->json($materials_through_boq_budgets);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function ProjectWiseBOQbudgetedMaterials(Request $request)
    {
        $search     = $request->search;
        $project_id = $request->project_id;

        $nested_material_ids = NestedMaterial::where('name', 'LIKE', '%' . $search . '%')
            ->get();
        $data = [];
        foreach ($nested_material_ids as $nested_material_id) {
            $descendant_nested_materials = NestedMaterial::descendantsAndSelf($nested_material_id->id)
                ->pluck('id')->toArray();

            $budget_materials = BoqSupremeBudget::where('project_id', $project_id)
                ->whereIn('material_id', $descendant_nested_materials)
                ->whereNull('floor_id')
                ->first();

            if (!empty($budget_materials->material_id)) {
                $materials_through_boq_budgets = NestedMaterial::descendantsAndSelf($budget_materials->material_id);

                foreach ($materials_through_boq_budgets as $key => $value)
                    $data[] = [
                        'label'            => $value->name,
                        'material_id'      => $value->id,
                        'unit'             => $value->unit->name,
                        'unit_id'          => $value->unit_id,
                        'quantity'         => $budget_materials->quantity,
                        'material_list'    => $materials_through_boq_budgets->pluck('id')->toArray(),
                    ];
            }
        }
        return response()->json($data);
    }


    /**
     * @param Request $request
     */
    public function materialAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = NestedMaterial::where('name', 'LIKE', "%$search%")->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label'         => $item->name,
                'value'         => $item->name,
                'material_id'   => $item->id,
                'unit'          => $item->unit
            ];
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function materialAutoSuggestWhereDepthThree(Request $request)
    {
        $search = $request->search;
        $items = NestedMaterial::where('name', 'LIKE', "%$search%")
            ->withDepth()
            ->having('depth', '=', 2)
            ->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->name,
                'material_id' => $item->id,
                'unit' => $item->unit
            ];
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function CheckMaterialAutoSuggestWhereDepthThree(Request $request)
    {
        $search = $request->search;
        $items = NestedMaterial::where('name', 'LIKE', "%$search%")
            ->withDepth()
            ->having('depth', '=', 2)
            ->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->name,
            ];
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function floorAutoSuggest(Request $request)
    {
        $search = $request->search;
        $project_id = $request->project_id;

        $items = BoqFloor::wherehas('boqFloorProject', function ($query) use ($project_id) {
            $query->where('project_id', $project_id);
        })
            ->With([
                'boqFloorProject' => function ($query) use ($project_id) {
                    $query->where('project_id', $project_id);
                }
            ])
            ->where('name', 'LIKE', "%$search%")
            ->limit(20)
            ->get();

        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'floor_id' => $item->boqFloorProject[0]->boq_floor_project_id
            ];
        }
        return response()->json($response);
    }

    public function projectAutoSuggestBeforeBOQ(Request $request)
    {
        $search = $request->search;
        $boq_supreme_budgets = BoqSupremeBudget::get()->pluck('project_id');
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->whereNotIn('project_id', $boq_supreme_budgets)
            ->orWhereNull('project_id')
            ->limit(5)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }

    /**
     * @param Request $request
     */

    public function mprAutoSuggest(Request $request)
    {
        $search = $request->search;
        $approval_layer = ApprovalLayer::where('name', 'like', 'Requisition%')->orWhere('name', 'like', 'General Requisition%')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->last();

        $requistion = Requisition::where('mpr_no', $request->search)->first();
        $requistionApproval = Approval::whereHas('approvable', function ($q) use ($requistion) {
            $q->where('approvable_id', $requistion->id);
            $q->where('approvable_type', Requisition::class);
        })->orderBy('id', 'desc')->first();

        if ($approval_layer_details = $requistionApproval) {
            $items = Requisition::where('mpr_no', 'like', '%' . $search . '%')
                ->get()
                ->map(fn ($item) => [
                    'value'             => $item->id,
                    'label'             => $item->mpr_no,
                    'date'              => $item->applied_date,
                    'project_id'        => $item->costCenter->name,
                    'po_project_id'     => $item->costCenter->project_id,
                    'cost_center_id'    => $item->costCenter->id,
                    'receiver_contact'  => $item?->requisitionBy?->employee?->phone_1 ?? "N/A",
                    'receiver_name'     => $item?->requisitionBy?->employee?->emp_name ?? 'N/A',
                ]);
            return response()->json($items);
        }
    }


    /**
     * @param Request $request
     */
    public function requisitionWiseMaterialAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = NestedMaterial::where('name', 'LIKE', "%$search%")
            ->get();

        $response = [];
        foreach ($items as $item) {
            $response[] = ['label' => $item->name, 'value' => $item->name, 'material_id' => $item->id, 'unit' => $item->unit];
        }
        return response()->json($response);
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

        return Requisitiondetails::with('nestedMaterial.unit')
            ->orderBy('id')
            ->where('requisition_id', $mpr_id)
            ->whereIn('material_id', $materials)
            ->groupBy('material_id')
            ->get();
        // return Requisitiondetails::with('nestedMaterial.unit')
        //     ->orderBy('id')
        //     ->where('requisition_id', $mpr_id)
        //     ->whereIn('material_id', function($query) use($cs_id) {
        //         $query->select('material_id')
        //               ->from('cs_materials')
        //               ->where('cs_id', $cs_id);
        //     })
        //     ->groupBy('material_id')
        //     ->get();
    }

    /**
     * @param $material_id
     * @param $mpr_no
     * @return mixed
     */
    public function loadrequisitionmaterial($material_id, $mpr_no)
    {
        $requisition_details = Requisitiondetails::with('nestedMaterial.unit')
            ->where('requisition_id', $mpr_no)
            ->where('material_id', $material_id)
            ->get();

        // $purchase_order = PurchaseOrder::where('mpr_no', $mpr_no)
        //     ->wherehas('purchaseOrderDetails', function ($query) use ($material_id) {
        //         return $query->where('material_id', $material_id);
        //     })
        //     ->get();

        $purchaseOrderDetails = PurchaseOrderDetail::where('material_id', $material_id)
            ->whereHas('purchaseOrder', function ($query) use ($mpr_no) {
                $query->where('mpr_no', $mpr_no);
            })
            ->sum('quantity');

        return response()->json([
            'value'         => $requisition_details->first()->nestedMaterial->unit->name,
            'sum'           => $requisition_details->sum('quantity'),
            'po_quantity'   => $purchaseOrderDetails ?? 0
        ]);
    }

    /**
     * @param Request $request
     */
    public function MprAutoSuggestWithPO(Request $request)
    {
        $search = $request->search;
        $approval_layer = ApprovalLayer::where('name', 'Purchase Order')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();
        $items = Requisition::with('purchaseOrder')
            ->whereHas('purchaseOrder.approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details)->where('status', 1);
            })
            ->where('mpr_no', 'like', '%' . $search . '%')
            ->get(['id', 'mpr_no', 'cost_center_id'])
            ->map(fn ($item) => [
                'mpr_id'            => $item->id,
                'value'             => $item->mpr_no,
                'project_id'        => $item->costCenter->project_id,
                'project_name'      => $item->costCenter->name,
                'po_no'             => $item->purchaseOrder->po_no,
                'date'              => $item->purchaseOrder->date,
                'cs_no'             => $item->purchaseOrder->cs->reference_no,
                'po_id'             => $item->purchaseOrder->id,
                'cost_center_id'    => $item->cost_center_id
            ]);

        return response()->json($items);
    }


    /**
     * @param Request $request
     */
    public function SupplierWisePo(Request $request)
    {
        $search = $request->search;
        $supplier_id = $request->supplier_id;
        $approval_layer = ApprovalLayer::where('name', 'Purchase Order')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();
        $purchase_order = PurchaseOrder::query()
            ->with('purchaseOrderDetails')
            ->whereHas('approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details)->where('status', 1);
            })
            ->where('supplier_id', $supplier_id)
            ->where('po_no', 'like', '%' . $search . '%')
            ->get()
            ->map(fn ($item) => [
                'label'            => $item->po_no,
                'value'             => $item->po_no,
            ]);

        return response()->json($purchase_order);
    }



    public function loadMPRWiseFloor($requisition_id)
    {
        $items = Requisitiondetails::with('boqFloor')
            ->where('requisition_id', $requisition_id)
            ->whereNotNull('floor_id')
            ->groupBy('floor_id')
            ->orderBy('floor_id', 'desc')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->boqFloor->name,
                'value'  => $item->boqFloor->id
            ]);

        return response()->json($items);
    }

    /**
     * @param Request $request
     */

    public function floorWsiseRequisitionMaterials(Request $request)
    {
        $search         = $request->search;
        $po_no          = $request->po_no;
        $requisition_id = $request->requisition_id;
        $floor_id       = $request->floor_name;

        $purchase_order = PurchaseOrder::with('purchaseOrderDetails')
            ->where('po_no', $po_no)
            ->first();

        $po_materials = $purchase_order->purchaseOrderDetails->pluck('material_id')->toArray();

        $items = Requisitiondetails::where('requisition_id', $requisition_id)
            ->where('floor_id', $floor_id)
            ->whereIn('material_id', $po_materials)
            ->whereHas('nestedMaterial', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label'         => $item->nestedMaterial->name,
                'material_id'   => $item->nestedMaterial->id,
                'unit'          => $item->nestedMaterial->unit->name,
                'quantity'      => $item->quantity
            ];
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     */

    public function projectWsiseRequisitionMaterials(Request $request)
    {
        $search         = $request->search;
        $po_no          = $request->po_no;
        $requisition_id = $request->requisition_id;

        $purchase_order = PurchaseOrder::with('purchaseOrderDetails')
            ->where('po_no', $po_no)
            ->first();

        $po_materials = $purchase_order->purchaseOrderDetails->pluck('material_id')->toArray();

        $items = Requisitiondetails::where('requisition_id', $requisition_id)
            ->whereNull('floor_id')
            ->whereIn('material_id', $po_materials)
            ->whereHas('nestedMaterial', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label'         => $item->nestedMaterial->name,
                'material_id'   => $item->nestedMaterial->id,
                'unit'          => $item->nestedMaterial->unit->name,
                'quantity'      => $item->quantity
            ];
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function headOfficeWiseRequisitionMaterials(Request $request)
    {
        $search         = $request->search;
        $po_no          = $request->po_no;
        $requisition_id = $request->requisition_id;

        $purchase_order = PurchaseOrder::with('purchaseOrderDetails')
            ->where('po_no', $po_no)
            ->first();

        $po_materials = $purchase_order->purchaseOrderDetails->pluck('material_id')->toArray();

        $items = Requisitiondetails::where('requisition_id', $requisition_id)
            ->whereNull('floor_id')
            ->whereIn('material_id', $po_materials)
            ->whereHas('nestedMaterial', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();

        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label'         => $item->nestedMaterial->name,
                'material_id'   => $item->nestedMaterial->id,
                'unit'          => $item->nestedMaterial->unit->name,
                'quantity'      => $item->quantity
            ];
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     */

    public function getFloorForMaterials(Request $request)
    {
        $mpr_id = $request->mpr_id;

        $items = Requisition::with('requisitiondetails')
            ->where('id', $mpr_id)
            ->get()
            ->first()
            ->requisitiondetails;
        return response()->json($items);
    }


    /**
     * @param Request $request
     */

    public function getRequisitionMaterialDetailsForRow(Request $request)
    {
        $po_no          = $request->po_no;
        $cost_center_id = $request->cost_center_id;
        $material_id    = $request->material_id;
        $requisition_id = $request->requisition_id;
        $floor_id       = $request->floor_id;
        $po_id       = $request->po_id;
        $items = Requisitiondetails::where('requisition_id', $requisition_id)
            ->where('floor_id', $floor_id)
            ->where('material_id', $material_id)
            ->get();

        $mrr_quantity = StockHistory::where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->latest()
            ->get();

        $material_receive_project_id = MaterialReceive::query()
            ->where('cost_center_id', $cost_center_id)
            ->groupBy('cost_center_id')
            ->first();

        if (!empty($material_receive_project_id)) {
            if ($cost_center_id && $floor_id && $material_id) {
                $total_material_qty_in_po = PurchaseOrderDetail::query()
                    ->whereHas('purchaseorder', function ($query) use ($requisition_id) {
                        $query->where('mpr_no', $requisition_id);
                    })
                    ->get()
                    ->where('material_id', $material_id)
                    ->sum('quantity');

                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id, $po_no) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id)
                            ->where('po_no', $po_no);
                    })
                    ->where('floor_id', $floor_id)
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            } elseif ($cost_center_id && $material_id) {
                $total_material_qty_in_po = PurchaseOrderDetail::query()
                    ->whereHas('purchaseorder', function ($query) use ($requisition_id) {
                        $query->where('mpr_no', $requisition_id);
                    })
                    ->get()
                    ->where('material_id', $material_id)
                    ->sum('quantity');
                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id, $po_no) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id)
                            ->where('po_no', $po_no);
                    })
                    ->whereNull('floor_id')
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            }
        }
        $po_brand = PurchaseOrderDetail::where('purchase_order_id', $request->po_id)
            ->where('material_id', $material_id)
            ->get()
            ->first()
            ?->brand;
        return response()->json([
            'unit'                              => $items->first()->nestedMaterial->unit->name,
            'quantity'                          => $items->first()->quantity,
            'mrr_quantity'                      => $mrr_quantity->first()->present_stock ?? 0,
            'material_receive_quantity_sum'     => $material_receive_details_quantity_sum ?? 0,
            'total_material_qty_in_po'          => $total_material_qty_in_po ?? 0,
            'brand'                             => $po_brand ?? '--'
        ]);
    }

    /**
     * @param Request $request
     */
    public function getRequisionDetailsByProjectAndMaterial(Request $request)
    {
        $requisition_id  = $request->requisition_id;
        $cost_center_id  = $request->cost_center_id;
        $project_id      = $request->project_id;
        $floor_id        = $request->floor_name;
        $material_id     = $request->material_id;

        if ($project_id && $floor_id) {
            $requisition_quantity = Requisitiondetails::whereHas('requisition.costCenter', function ($query) use ($project_id) {
                return $query->where('project_id', $project_id);
            })
                ->where('floor_id', $floor_id)
                ->where('material_id', $material_id)
                ->get()
                ->sum('quantity');
        } elseif ($project_id) {
            $requisition_quantity = Requisitiondetails::whereHas('requisition.costCenter', function ($query) use ($project_id) {
                return $query->where('project_id', $project_id);
            })
                ->whereNull('floor_id')
                ->where('material_id', $material_id)
                ->get()
                ->sum('quantity');
        } elseif ($project_id == null && $floor_id == null) {
            $requisition_quantity = Requisitiondetails::whereHas('requisition.costCenter', function ($query) {
                return $query->whereNull('project_id');
            })
                ->whereNull('floor_id')
                ->where('material_id', $material_id)
                ->get()
                ->sum('quantity');
        } else {
        }

        $material_receive_project_id = MaterialReceive::where('cost_center_id', $cost_center_id)
            ->groupBy('cost_center_id')
            ->first();

        if (!empty($material_receive_project_id)) {
            if ($cost_center_id && $floor_id && $material_id) {
                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id);
                    })
                    ->where('floor_id', $floor_id)
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            } elseif ($cost_center_id && $material_id) {
                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id);
                    })
                    ->whereNull('floor_id')
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            } else {
            }
        }

        $present_stock_in_stock_history = StockHistory::where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->latest()
            ->get();

        return response()->json([
            'requisition_quantity'              => !empty($requisition_quantity) ? $requisition_quantity : 0, //used in requision
            'material_receive_quantity_sum'     => !empty($material_receive_details_quantity_sum) ? $material_receive_details_quantity_sum : 0, //used in requision+mrr
            'present_stock_in_stock_history'    => $present_stock_in_stock_history->isNotEmpty() ? $present_stock_in_stock_history[0]->present_stock : 0 //used in requisition
        ]);
    }
    /**
     * @param Request $request
     */
    public function getMrrDetailsByProjectAndMaterial(Request $request)
    {
        $requisition_id  = $request->requisition_id;
        $cost_center_id  = $request->cost_center_id;
        $floor_id        = $request->floor_name;
        $material_id     = $request->material_id;
        $po_no           = $request->po_no;

        $material_receive_project_id = MaterialReceive::where('cost_center_id', $cost_center_id)
            ->groupBy('cost_center_id')
            ->first();

        if (!empty($material_receive_project_id)) {
            if ($cost_center_id && $floor_id && $material_id) {
                $total_material_qty_in_po = PurchaseOrderDetail::query()
                    ->whereHas('purchaseorder', function ($query) use ($requisition_id) {
                        $query->where('mpr_no', $requisition_id);
                    })
                    ->get()
                    ->where('material_id', $material_id)
                    ->sum('quantity');

                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id, $po_no) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id)->where('po_no', $po_no);
                    })
                    ->where('floor_id', $floor_id)
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            } elseif ($cost_center_id && $material_id) {
                $total_material_qty_in_po = PurchaseOrderDetail::query()
                    ->whereHas('purchaseorder', function ($query) use ($requisition_id) {
                        $query->where('mpr_no', $requisition_id);
                    })
                    ->get()
                    ->where('material_id', $material_id)
                    ->sum('quantity');

                $material_receive_details_quantity_sum = Materialreceiveddetail::with('materialreceive')
                    ->whereHas('materialreceive', function ($query) use ($material_receive_project_id, $po_no) {
                        return $query->where('cost_center_id', $material_receive_project_id->cost_center_id)->where('po_no', $po_no);
                    })
                    ->whereNull('floor_id')
                    ->where('material_id', $material_id)
                    ->get()
                    ->sum('quantity');
            } else {
            }
        }

        return response()->json([
            'material_receive_quantity_sum'     => !empty($material_receive_details_quantity_sum) ? $material_receive_details_quantity_sum : 0, //used in requision+mrr
            'total_material_qty_in_po'          => !empty($total_material_qty_in_po) ? $total_material_qty_in_po : 0, //used in mrr
        ]);
    }

    /**mrr_stock_quantity
     * @param Request $request
     */
    public function getMrrQuantity(Request $request)
    {
        $po_no          = $request->po_no;
        $floor_id       = $request->floor_name;
        $material_id    = $request->material_id;

        if ($floor_id && $material_id) {
            $mrr_quantity = Materialreceiveddetail::whereHas('materialReceive', function ($query) use ($po_no) {
                return $query->where('po_no', $po_no);
            })
                ->where('floor_id', $floor_id)
                ->where('material_id', $material_id)
                ->first();
        } elseif ($material_id) {
            $mrr_quantity = Materialreceiveddetail::whereHas('materialReceive', function ($query) use ($po_no) {
                return $query->where('po_no', $po_no);
            })
                ->whereNull('floor_id')
                ->where('material_id', $material_id)
                ->first();
        }

        return response()->json([
            'mrr_quantity'              => !empty($mrr_quantity) ? $mrr_quantity->quantity : 0
        ]);
    }

    /**
     * @param Request $request
     */

    public function getPresentStockQuantity(Request $request)
    {

        $cost_center_id = $request->cost_center_id;
        $material_id    = $request->material_id;
        $mrr_quantity = StockHistory::where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->latest()
            ->get();
        $po_brand = PurchaseOrderDetail::where('purchase_order_id', $request->po_id)
            ->where('material_id', $material_id)
            ->get()
            ->first();

        return response()->json([
            'mrr_quantity' =>  $mrr_quantity[0]->present_stock ?? 0,
            'po_brand'     => $po_brand->brand ?? ''
        ]);
    }


    public function getMaterialsAndQuantityByPoNo($po_no)
    {
        $purchase_order_details = PurchaseOrderDetail::with('nestedMaterials')
            ->whereHas('purchaseorder', function ($query) use ($po_no) {
                return $query->where('po_no', $po_no);
            })
            ->get();

        $response = [];
        foreach ($purchase_order_details as $item) {

            $response[] = [
                'material_name'         => $item->nestedMaterials->name,
                'material_id'           => $item->material_id,
                'po_quantity'           => $item->quantity,
                'po_price'              => $item->unit_price
            ];
        }
        return response()->json($response);
    }

    public function getMaterialsAndQuantityByMprNo($mpr_no, $po_no)
    {

        $purchase_order_details = PurchaseOrderDetail::with('nestedMaterials')
            ->whereHas('purchaseorder', function ($query) use ($po_no) {
                return $query->where('po_no', $po_no);
            })
            ->pluck('material_id')->toArray();

        $pr_details = Requisitiondetails::with('nestedMaterial')
            ->whereHas('requisition', function ($query) use ($mpr_no) {
                return $query->where('mpr_no', $mpr_no);
            })
            ->get();

        $response = [];
        foreach ($pr_details as $item) {
            if (in_array($item->material_id, $purchase_order_details)) {
                $response[] = [
                    'material_name'         => $item->nestedMaterial->name,
                    'material_id'           => $item->material_id,
                    'floor_id'              => $item->floor_id
                ];
            }
        }
        return response()->json($response);
    }


    public function projectAutoSuggestWithoutBOQ(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadMrr(Request $request)
    {

        $search = $request->search;
        $cost_center_id = $request->cost_center_id;
        $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->get();
        $approval_layer_details = $approval_layer[0]->approvalLeyarDetails->last();

        $items = MaterialReceive::with('approval')
            ->whereHas('approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details->layer_key)->where('status', 1);
            })
            ->where('mrr_no', 'LIKE', "%${search}%")
            ->where('cost_center_id', $cost_center_id)
            ->get(['id', 'mrr_no'])
            ->map(fn ($item) => ['value' => $item->id, 'label' => $item->mrr_no]);

        return response()->json($items);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function loadMrrBasedOnSupplier(Request $request)
    {

        $search = $request->search;
        $cost_center_id = $request->cost_center_id;
        $supplier_id = $request->supplier_id;
        $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->get();
        $approval_layer_details = $approval_layer[0]->approvalLeyarDetails->last();

        $items = MaterialReceive::with('approval')
            ->whereHas('approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details->layer_key)->where('status', 1);
            })
            ->where('mrr_no', 'LIKE', "%${search}%")
            ->where('cost_center_id', $cost_center_id)
            ->whereHas("purchaseorder", function ($query) use ($supplier_id) {
                return $query->where('supplier_id', $supplier_id);
            })
            ->get(['id', 'mrr_no'])
            ->map(fn ($item) => ['value' => $item->id, 'label' => $item->mrr_no]);

        return response()->json($items);
    }


    public function getMaterialsAndQuantityByMpr($mpr_no)
    {

        $purchase_order_details = Requisitiondetails::with('nestedMaterial')
            ->whereHas('requisition', function ($query) use ($mpr_no) {
                return $query->where('id', $mpr_no);
            })
            ->get()
            ->groupBy('material_id');

        $response = [];
        foreach ($purchase_order_details as $key => $items) {
            foreach ($items as $item) {
                $data = $item->nestedMaterial->name;
            }
            $quantity = $items->flatten()->sum('quantity');
            $response[] = [
                'material_name'         => $data,
                'material_id'           => $key,
                'po_quantity'           => $quantity
            ];
        }
        return response()->json($response);
    }


    public function getMrrByProject($cost_center_id)
    {
        $items = MaterialReceive::where('cost_center_id', $cost_center_id)
            ->get(['id', 'mrr_no'])
            ->map(fn ($item) => ['value' => $item->id, 'label' => $item->mrr_no]);;

        return response()->json($items);
    }

    public function getMrrByProjectAndSupplier($cost_center_id,$supplier_id)
    {
        $items = MaterialReceive::where('cost_center_id', $cost_center_id)
            ->whereHas("purchaseorder", function ($query) use ($supplier_id) {
                return $query->where('supplier_id', $supplier_id);
            })
            ->get(['id', 'mrr_no'])
            ->map(fn ($item) => ['value' => $item->id, 'label' => $item->mrr_no]);;

        return response()->json($items);
    }

    public function projectAutoSuggestAfterMRR(Request $request)
    {
        $search = $request->search;
        $material_receive_cost_center_id = MaterialReceive::get()->pluck('cost_center_id');

        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->whereIn('id', $material_receive_cost_center_id)
            ->limit(5)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value'         => $item->id,
                'project_id'    => $item->project_id,
                'label'         => $item->name
            ]);

        return response()->json($items);
    }


    public function loadProjectWiseFloorAfterMrr($project_id)
    {
        $items = Materialreceiveddetail::with('materialReceive')
            ->whereHas('materialReceive.costCenter', function ($query) use ($project_id) {
                return $query->where('project_id', $project_id);
            })
            ->whereNotNull('floor_id')
            ->groupBy('floor_id')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->boqFloor->name ?? '',
                'value'  => $item->boqFloor->id ?? '',
            ]);
        return response()->json($items);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function floorswiseMrrMaterials(Request $request)
    {
        $search     = $request->search;
        $cost_center_id = $request->cost_center_id;
        $floor_name   = $request->floor_name;

        $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();

        $items = Materialreceiveddetail::with('materialReceive', 'nestedMaterials')
            ->whereHas('materialReceive.approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details)->where('status', 1);
            })
            ->wherehas('materialReceive', function ($q) use ($cost_center_id) {
                $q->where('cost_center_id', $cost_center_id);
            })
            ->whereHas('nestedMaterials', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->where('floor_id', $floor_name)
            ->get();


        $data = collect($items->pluck('nestedMaterials'))->unique()
            ->map(function ($data, $key) {
                return [
                    'label' => $data->name,
                    'material_id' => $data->id,
                    'unit_name' => $data->unit->name
                ];
            });

        return response()->json($data);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function projectWiseMrrMaterials(Request $request)
    {
        $search     = $request->search;
        $cost_center_id = $request->cost_center_id;

        $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();

        $items = Materialreceiveddetail::with('materialReceive', 'nestedMaterials')
            ->whereHas('materialReceive.approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details)->where('status', 1);
            })
            ->wherehas('materialReceive', function ($q) use ($cost_center_id) {
                $q->where('cost_center_id', $cost_center_id);
            })
            ->whereHas('nestedMaterials', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->whereNull('floor_id')
            ->get();


        $data = collect($items->pluck('nestedMaterials'))->unique()
            ->map(function ($data, $key) {
                return [
                    'label' => $data->name,
                    'material_id' => $data->id,
                    'unit_name' => $data->unit->name
                ];
            });

        return response()->json($data);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function headOfficeWiseMrrMaterials(Request $request)
    {
        $search     = $request->search;
        $cost_center_id = $request->cost_center_id;

        $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();

        $items = Materialreceiveddetail::with('materialReceive', 'nestedMaterials')
            ->whereHas('materialReceive.approval', function ($query) use ($approval_layer_details) {
                return $query->where('layer_key', $approval_layer_details)->where('status', 1);
            })
            ->wherehas('materialReceive', function ($q) use ($cost_center_id) {
                $q->where('cost_center_id', $cost_center_id);
            })
            ->whereHas('nestedMaterials', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->whereNull('floor_id')
            ->get();

        $sum = 0;
        $response = [];

        foreach ($items as $item) {
            $sum += $item->quantity;
        }

        $data = $items->groupBy('material_id')->first();

        $response[] = [
            'label'                 => $items[0]->nestedMaterials->name,
            'material_id'           => $items[0]->nestedMaterials->id,
            'unit_name'             => $items[0]->nestedMaterials->unit->name,
            'mrr_quantity'          => $sum
        ];

        return response()->json($response);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function getMrrDetailsByMaterial(Request $request)
    {
        $cost_center_id = $request->cost_center_id;
        $floor_name   = $request->floor_name;
        $material_id   = $request->material_id;

        $items = Materialreceiveddetail::with('materialReceive', 'nestedMaterials')
            ->wherehas('materialReceive', function ($q) use ($cost_center_id) {
                $q->where('cost_center_id', $cost_center_id);
            })
            ->where('floor_id', $floor_name)
            ->where('material_id', $material_id)
            ->get()
            ->groupBy('material_id')
            ->map(function ($item, $key) use ($cost_center_id, $material_id) {
                $stockIssue = StockHistory::where('cost_center_id', $cost_center_id)
                    ->whereNotNull('store_issue_id')->where('material_id', $material_id)->get()
                    ->groupBy('material_id');

                return [
                    'issue_total' => $stockIssue->flatten()->sum('quantity'),
                    'mrr_quantity' => $item->sum('quantity'),
                ];
            });
        return response()->json($items);
    }

    // public function getMaterialsAndQuantityByProject($cost_center_id){

    //     $stock_history_data = StockHistory::where('cost_center_id', $cost_center_id)->orderBy('created_at', 'desc')->get();
    //     $latest_material = $stock_history_data->unique('material_id');

    //     $response = [];
    //     foreach ($latest_material as $key => $items)
    //     {
    //         $response[] = [
    //             'material_name'         => $items->nestedMaterial->name,
    //             'stock_quantity'           => $items->present_stock
    //         ];
    //     }
    //     return response()->json($response);
    // }

    public function getMaterialsAndQuantityByProject(Request $request)
    {

        $cost_center_id = $request->cost_center_id;

        $stock_history_data = StockHistory::where('cost_center_id', $cost_center_id)->orderBy('created_at', 'desc')->get();
        $latest_material = $stock_history_data->unique('material_id');

        $response = [];
        foreach ($latest_material as $key => $items) {
            $response[] = [
                'material_name'         => $items->nestedMaterial->name,
                'stock_quantity'           => $items->present_stock
            ];
        }
        return response()->json($response);
    }

    public function designationNameAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = Designation::where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get(['id', 'name'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name
            ]);
        return response()->json($items);
    }


    public function bdLeadAtoSuggest(Request $request)
    {
        $search = $request->search;
        $items = BdLeadGeneration::with('BdLeadGenerationDetails')
            ->where('land_location', 'like', '%' . $search . '%')
            ->limit(5)
            ->get()
            ->map(fn ($item) => [
                'value'         => $item->id,
                'label'         => $item->land_location,
                'land_size'     => $item->land_size,
                'category'      => $item->category,
                'status'        => $item->status,
                'ownerName'     => $item->BdLeadGenerationDetails[0]->name
            ]);

        return response()->json($items);
    }


    /* search for child nested material*/
    public function getChildMaterial(Request $request)
    {
        $material_id = $request->material_id;
        $materials = NestedMaterial::with('descendants')
            ->where('parent_id', $material_id)
            ->orderBy('id')
            ->pluck('name', 'id');

        $option_view = '<option value="">Select material Name</option>';

        foreach ($materials as $key => $value) {
            $option_view .= "<option value='$key'>$value</option>";
        }
        return $option_view;
    }

    public function getEmeWorks(Request $request)
    {
        $search = $request->search;
        $item_id = $request->item_id;

        $materials = BoqEmeRate::where('parent_id_second', $item_id)
            ->where('boq_work_name', 'like', '%' . $search . '%')
            ->orderBy('id')
            ->get()
            ->map(function ($item) {
        return [
            'label' => $item->boq_work_name,
            'unit_name' => optional($item->laborUnit)->name,
            'boq_eme_rate_id' => $item->id,
            'labour_rate' => $item->labour_rate ?? 0
        ];
    });

    return response()->json($materials);
    }

    public function ConstructionTentativeBudgetProjectAutoSuggestWithBoq(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::with(['project.boqSupremeBudgets', 'project.boqSupremeBudgets'])
            ->where('name', 'like', '%' . $search . '%')
            ->limit(5)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'boq_civil_total_amount' => $item->project->boqCivilBudgets->sum('total_amount'),
                'boq_floor_project_area' => $item->project->boqFloorProjects->sum('area')
            ]);


        return response()->json($items);
    }

    public function getParentMaterial(Request $request)
    {
        $search = $request->material_id;
        $materials = NestedMaterial::with(['descendants', 'unit'])
            ->where('parent_id', null)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('id')
            // ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'label' => $item->name,
                'material_id' => $item->id,
                'unit_name' => $item->unit->name
            ]);
        return response()->json($materials);
    }

    public function getLayerParentMaterial(Request $request)
    {
        $search = $request->search;
        $parent_material_id = $request->parent_material_id;
        $materials = NestedMaterial::with('unit')
            ->where('parent_id', $parent_material_id)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('id')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->name,
                'material_id' => $item->id,
                'unit_name' => $item->unit->name
            ]);
        return response()->json($materials);
    }

    public function getLayer3MaterialRateWise(Request $request)
    {
        $search = $request->search;
        $item_id = $request->item_id;
        $material_id = $request->material_id;
        $materials = NestedMaterial::with('unit')
            ->where('parent_id', $item_id)
            ->whereHas('BoqEmeRate', function ($item) use ($item_id) {
                $item->where('parent_id_second', $item_id);
            })
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('id')
            ->get()
            ->map(fn ($item) => [
                'label' => $item->name,
                'material_id' => $item->id,
                'unit_name' => $item->unit->name,
                'boq_eme_rate_id' => $item->BoqEmeRate->id,
                'labour_rate' => $item->BoqEmeRate->labour_rate ?? 0
            ]);
        return response()->json($materials);
    }


    public function DepartmentWiseBillSearch(Request $request)
    {
        $search = $request->search;
        $items = BillRegister::where('serial_no', 'like', '%' . $search . '%')
            ->where(['department_id' => auth()->user()->department_id, 'deliver_status' => 1])
            ->limit(5)
            ->get(['id', 'serial_no', 'bill_no'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->serial_no,
                'bill_no' => $item->bill_no
            ]);

        return response()->json($items);
    }

    public function GetCsPriceforMpr($cs_id, $material_id, $supplier_id)
    {
        $price = CsMaterialSupplier::where('cs_id', $cs_id)
            ->whereHas('Csmaterial', function ($item) use ($material_id) {
                $item->where('material_id', $material_id);
            })
            ->whereHas('Cssupplier', function ($item) use ($supplier_id) {
                $item->where('supplier_id', $supplier_id);
            })
            ->get()
            ->first();

        return [
            'csPrice' => $price->price ?? 0
        ];
    }


    public function ProjectAutoSearchHavingIou(Request $request)
    {
        $project_name = Iou::query()
            ->with('costCenter')
            ->where('status', '!=', 'Pending')
            ->where('applied_by', auth()->id())
            ->whereHas('costCenter', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get()
            ->groupBy('cost_center_id')
            ->map(function ($item, $key) {
                $previous_balance = AdvanceAdjustment::query()
                    ->where('cost_center_id', $item[0]->cost_center_id)
                    ->where('user_id', auth()->id())
                    ->get()
                    ->sum('grand_total');
                return [
                    'value' => $item[0]->cost_center_id,
                    'label' => $item[0]->costCenter->name,
                    'sum'   => ($item->flatten()->sum('total_amount') - $previous_balance)
                ];
            });

        // dd($project_name);

        return response()->json($project_name);
    }

    public function SearchAccountHead(Request $request)
    {
        $account_name = Account::query()
            ->where('account_name', 'like', '%' . $request->search . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->account_name
            ]);

        return response()->json($account_name);
    }

    public function SearchIouNo(Request $request)
    {
        $iou_no = Iou::query()
            ->where('status', '!=', 'Pending')
            ->where('iou_no', 'like', '%' . $request->search . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value'             => $item->id,
                'label'             => $item->iou_no,
                'requisition_id'    => $item->requisition_id,
                'mpr_no'            => $item->mpr?->mpr_no ?? null,
            ]);

        return response()->json($iou_no);
    }

    public function getMrrByCostCenter(Request $request)
    {
        $items = MaterialReceive::where([['cost_center_id', $request->cost_center_id], ['mrr_no', 'like', '%' . $request->search . '%'], ['status', '!=', 'Pending']])
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->mrr_no
            ]);

        return response()->json($items);
    }

    public function getMrrByCostCenterAndIou(Request $request)
    {
        $items = MaterialReceive::where('cost_center_id', $request->cost_center_id)
            ->where([['iou_id', $request->iou_id], ['mrr_no', 'like', '%' . $request->search . '%']])
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->mrr_no
            ]);

        return response()->json($items);
    }

    public function getMprByCostCenter(Request $request)
    {
        $items = Requisition::where('cost_center_id', $request->cost_center_id)
            ->where('mpr_no', 'like', '%' . $request->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->mpr_no,
            ]);

        return response()->json($items);
    }


    public function projectAutoSuggestwithCostCenter(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            // ->whereNotNull('project_id')
            ->limit(15)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }



    public function getBoqBudgetMax(Request $request)
    {
        $material_id = $request->material_id;
        $project_id = $request->project_id;
        $items = BoqSupremeBudget::query()
            ->where('material_id', $material_id)
            ->where('project_id', $project_id)
            ->get()
            ->sum('quantity');
        return response()->json($items);
    }
    public function materialAutoSuggestHavingBoqOrAll(Request $request)
    {
        // dd($request->all());
        if ($request->project_id) {
            $items = NestedMaterial::query()
                ->with('unit')
                ->where('name', 'like', '%' . $request->search . '%')
                ->whereHas('boqSupremeBudgets', function ($query) use ($request) {
                    return $query->where('project_id', $request->project_id);
                })
                ->limit(15)
                ->get();
        } else {
            $items = NestedMaterial::query()
                ->with('unit')
                ->where('name', 'like', '%' . $request->search . '%')
                ->limit(15)
                ->get();
        }
        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->name,
                'material_id' => $item->id,
                'unit' => $item->unit
            ];
        }
        return response()->json($response);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function LoadSgsf(Request $request)
    {

        $search = $request->search;
        $cost_center_id = $request->cost_center_id;
        // $approval_layer = ApprovalLayer::where('name', 'Material Receive Report')->get();
        // $approval_layer_details = $approval_layer[0]->approvalLeyarDetails->last();

        $items = ScrapForm::
            // $items = MaterialReceive::with('approval')
            // ->whereHas('approval', function ($query) use ( $approval_layer_details){
            //     return $query->where('layer_key', $approval_layer_details->layer_key)->where('status', 1);
            // })
            where('sgsf_no', 'LIKE', "%${search}%")
            ->where('cost_center_id', $cost_center_id)
            ->get(['id', 'sgsf_no'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->sgsf_no
            ]);

        return response()->json($items);
    }

    public function getSgsfMaterial($sgsf_id)
    {

        $items = ScrapFormDetail::whereHas('scrapForm', function ($query) use ($sgsf_id) {
            return $query->where('id', $sgsf_id);
        })
            ->get()
            ->map(fn ($item) => [
                'material_id'       => $item->material_id,
                'material_name'     => $item->nestedMaterial->name,
                'unit'              => $item->nestedMaterial->unit->name,
            ]);
        return $items;
    }

    public function scrapCsAutoSuggest(Request $request)
    {

        $search = $request->search;

        $items = ScrapCs::query()
            ->where('reference_no', 'LIKE', "%${search}%")
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->reference_no,
                'project_name' => $item->costCenter->name,
                'project_id' => $item->costCenter->project_id,
                'cost_center_id' => $item->cost_center_id
            ]);

        return response()->json($items);
    }

    public function materialAutoSuggestForScrap(Request $request)
    {

        $search = $request->search;
        $supplier_id = $request->supplier_id;
        $scrap_cs_id = $request->scrap_cs_id;

        $items = ScrapCsMaterialSupplier::query()
            ->where('scrap_cs_id', $scrap_cs_id)
            ->whereHas('Cssupplier', function ($item) use ($supplier_id) {
                $item->where('supplier_id', $supplier_id);
            })->whereHas('Csmaterial', function ($item) use ($search) {
                $item->whereHas('nestedMaterial', function ($item1) use ($search) {
                    $item1->where('name', 'like', "%$search%");
                });
            })

            ->get()
            ->map(fn ($item) => [
                'value' => $item->Csmaterial->material_id,
                'label' => $item->Csmaterial->nestedMaterial->name,
                'unit' => $item->Csmaterial->nestedMaterial->unit->name,
                'price' => $item->price
            ]);
        return response()->json($items);
    }

    public function supplierAutoSuggestForScrap(Request $request)
    {

        $search = $request->search;
        $scrap_cs_id = $request->scrap_cs_id;

        $items = ScrapCsMaterialSupplier::query()
            ->with('Cssupplier.supplier')
            ->where('scrap_cs_id', $scrap_cs_id)
            ->whereHas('Cssupplier', function ($item) use ($search) {
                $item->where('is_checked', 1)->whereHas('supplier', function ($ite) use ($search) {
                    $ite->where('name', 'like', "%${search}%");
                });
            })
            ->get()
            ->unique('Cssupplier.supplier_id')
            ->map(fn ($item) => [
                'value' => $item->Cssupplier->supplier_id,
                'label' => $item->Cssupplier->supplier->name,
            ]);

        return response()->json($items);
    }


    public function getMTRFInfobyMaterial(Request $request)
    {
        $search = $request->search;
        $mtrf_id = $request->mtrf_id;

        $items = MovementRequisitionDetail::query()
            ->whereHas('movementRequisition', function ($query) use ($mtrf_id) {
                $query->where('id', $mtrf_id);
            })
            ->whereHas('nestedMaterial', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->get()
            ->map(fn ($item) => [
                'value'   => $item->nestedMaterial->id,
                'label'   => $item->nestedMaterial->name,
                'unit'    => $item->nestedMaterial->unit->name,
                'mtr_qty' => $item->quantity,
            ]);

        //         $items = $movementRequisitions->movementRequisitionDetails()->with('nestedMaterial','nestedMaterial.unit')
        //         ->where('material_id',$material_id)->first();
        // return $items;

        return response()->json($items);
    }

    public function loadFixedCost($material_id)
    {
        $data = FixedAsset::query()
            ->where('material_id', $material_id)
            ->get();

        return $data;
    }


    public function getScrapMaterial(Request $request)
    {
        $search = $request->search;
        $items = NestedMaterial::where('name', 'LIKE', "%$search%")->where('material_status', 'Scrap Material')->get();
        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'value'         => $item->id,
                'label'         => $item->name,
                'unit'          => $item->unit->name
            ];
        }
        return response()->json($response);
    }

    public function getUnitForMaterial(Request $request)
    {
        $search = $request->getUnitForMaterial;
        $items = NestedMaterial::where('id', $request->material_id)
            ->limit(5)
            ->get()
            ->pluck('unit.name');
        return response()->json($items);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function getFARvalue(Request $request)
    {
        // $katha = 9.5;
        $katha = $request->proposed_land_area;
        $land_category = $request->project_category;
        // $road = 17;  //convert feet to meter
        $road = $request->front_road_width * 0.3048;  //convert feet to meter
        // $far_for = 'katha';
        $far_for = $request->far_for;

        // dd($katha, $land_category, $road, $far_for);
        // dump(
        //     $katha, $land_category, $road, $far_for,
        //     $katha <= 20 && $far_for == 'katha',
        //     $katha > 20 && $far_for == 'katha',
        //     $road >= 18 && $road < 24 && $far_for == 'road',
        //      $road >= 24 && $far_for == 'road'
        //     );

        $item = BdFeasibilityFarChart::where('land_category', $land_category)
            ->when(empty($far_for), function ($q)  use ($katha) {
                $q->where([
                    ['start_land_size_katha', '<=', $katha],
                    ['end_land_size_katha', '>=', $katha],
                ]);
            })
            ->when($katha <= 20 && $far_for == 'katha', function ($q) use ($katha) {
                $q->where([
                    ['start_land_size_katha', '<=', $katha],
                    ['end_land_size_katha', '>=', $katha],
                ]);
            })
            ->when($katha > 20 && $far_for == 'katha', function ($q) use ($katha) {
                $q->where('start_land_size_katha', '>', 20);
            })
            ->when($road >= 18 && $road < 24 && $far_for == 'road', function ($q) use ($road) {
                $q->whereBetween('road_meter', [18, 23.99]);
            })
            ->when($road >= 24 && $far_for == 'road', function ($q) use ($road) {
                $q->where('road_meter', '>=', 24);
            })
            ->first();
        //    dd($item->toArray());
        return response()->json($item);
    }

    /**
     * @param Request $request
     */
    public function permissionHeadAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = BdFeasiPerticular::where('name', 'LIKE', "%$search%")->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label'                     => $item->name,
                'permission_headble_id'     => $item->id,
                'unit'                      => $item->unit->name
            ];
        }

        //        dd($response);
        return response()->json($response);
    }

    public function permissionHeadAutoSuggestwithType(Request $request)
    {
        $search = $request->search;
        $type = $request->type;

        $data = str_replace('_', ' ', $type);
        $data = str_replace('and', '&', $data);

        $items = BdFeasiPerticular::query()
            ->where('type', $data)
            ->where('name', 'LIKE', "%$search%")
            ->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label'                     => $item->name,
                'permission_headble_id'     => $item->id,
                'unit'                      => $item->unit->name
            ];
        }

        //        dd($response);
        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function referenceHeadAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = BdFesiReferenceFess::where('name', 'LIKE', "%$search%")->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label'                 => $item->name,
                'reference_headble_id'     => $item->id
            ];
        }
        return response()->json($response);
    }

    /**
     * @param Request $request
     */
    public function generatorHeadAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = NestedMaterial::where('name', 'LIKE', "%$search%")
            ->get();
        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label'                     => $item->name,
                'generator_headble_id'      => $item->id,
                'unit'                      => $item->unit->name
            ];
        }
        return response()->json($response);
    }


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function getProposedStory(Request $request)
    {
        $location_id = $request->location_id;

        $item = BdFeasibilityEntry::with('BdLeadGeneration', 'ProjectLayout')
            ->where('location_id', $location_id)
            ->first();

        $ProjectLayoutData = ProjectLayout::query()
            ->where('bd_lead_location_id', $location_id)
            ->first();

        $story = $ProjectLayoutData ? ceil(explode(' ', $ProjectLayoutData->proposed_story)[2]) : 0;
        $floors = BoqFloor::where('name', 'LIKE', "%Floor%")
            ->get(['id', 'name'])
            ->toArray();
        return response()->json([
            'proposed_story' => $story,
            'rfpl_ratio' => $item->rfpl_ratio ?? 0,
            'bonus_saleable_area' => $item->bonus_saleable_area ?? 0,
            'total_far' => $item->ProjectLayout?->total_far ?? 0,
            'land_size' => $item->BdLeadGeneration->land_size ?? 0,
            'floor' => $floors,
            'proposed_mgc' => $ProjectLayoutData->proposed_mgc ?? 0,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function getFeasibilityEntryData(Request $request)
    {
        $location_id = $request->location_id;

        $feasibilityentry = BdFeasibilityEntry::with(
            'BdLeadGeneration',
            'ProjectLayout',
            'BdFeasibilityCtc.BdFeasiCtcDetail',
            'BdFeasiRevenue.BdFeasiRevenueDetail',
            'BdFeasiFessAndCost.BdFeasiFessAndCostDetail'
        )
            ->where('location_id', $location_id)
            ->first();
        $rnc = BdFeasiRncCal::with('BdFeasRncCalCost', 'BdFeasRncCalRate', 'BdFeasRncCalSale')
            ->where('bd_lead_generation_id', $location_id)
            ->first();

        return response()->json([
            'feasibilityentry' =>    $feasibilityentry,
            'rnc'             =>    $rnc
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function getTotalCostwithoutInterest(Request $request)
    {
        $data = $this->InflowAndOutflowService->getTotalCostwithoutInterest($request->location_id);
        return $data;
    }



    public function bd_sourceAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = Source::query()
            ->where('name', 'like', '%' . $search . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name
            ]);
        return response()->json($items);
    }

    public function projectAutoSuggestForScrap(Request $request)
    {
        $search = $request->search;
        $items = CostCenter::where('name', 'like', '%' . $search . '%')
            ->whereNotNull('project_id')
            ->limit(10)
            ->get(['id', 'name', 'project_id'])
            ->map(fn ($item) => [
                'value' => $item->id,
                'project_id' => $item->project_id,
                'label' => $item->name
            ]);

        return response()->json($items);
    }

    /**
     * @param Request $request
     */
    public function feasiFloorAutoSuggest(Request $request)
    {
        $search = $request->search;

        $items = BoqFloor::where('name', 'LIKE', "%$search%")
            ->limit(10)
            ->get();

        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->id
            ];
        }
        return response()->json($response);
    }

    public function getSubStructureTotal($location_id)
    {

        $fees_and_cost_details = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('statuts', 1)->where('type', 'Substructure');
            })
            ->get()->map(function ($item) {
                return $item->rate * $item->quantity;
            })->sum();
        //    dd($fees_and_cost_details);
        $other_costs = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('type', 'Permission Fees');
            })
            ->get()->map(function ($item) {
                return $item->rate * $item->quantity;
            })->sum();;

        //        dd($other_costs);
        $ConstructionCostFloor = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {

                $query->whereIn('type', ['Superstructure & Finishing', 'EME', 'BOQ-Utility']);
            })
            ->get()->map(function ($item) {
                return $item->rate * $item->quantity;
            })->sum();

        //    dd($ConstructionCostFloor);
        $ConstructionCostBasement = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('statuts', 2)->where('type', 'Substructure');
            })
            ->get()->first();

        //        dd($ConstructionCostBasement->toArray());
        $FinanceCost = BdFeasiFinanceDetail::query()
            ->whereHas('bd_feasi_finance', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })->get()->sum('interest');
        return [
            'service_pile_cost'         =>  $fees_and_cost_details,
            'other_costs'               =>  $other_costs,
            'ConstructionCostFloor'     =>  $ConstructionCostFloor,
            'ConstructionCostBasement'  =>  $ConstructionCostBasement ? $ConstructionCostBasement->rate : 0,
            'finance_cost'              =>  $FinanceCost
        ];
    }


    /**
     * @param Request $request
     */
    public function findSupplierDetailInfo(Request $request)
    {
        $item = CsSupplier::query()
            ->where('cs_id', $request->cs_id)
            ->where('supplier_id', $request->supplier_id)
            ->get(['vat_tax', 'tax', 'delivery_condition'])
            ->first();
        $response = [
            'vat_tax' => $item->vat_tax,
            'tax' => $item->tax,
            'delivery_condition' => $item->delivery_condition,
        ];
        return response()->json($response);
    }

    public function allFloorAutoSuggest(Request $request)
    {
        $search = $request->search;
        $items = BoqFloor::query()
            ->where('name', 'like', "%$search%")
            ->limit(20)
            ->get();

        $response = [];

        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->id
            ];
        }
        return response()->json($response);
    }

    public function percentForYearAndLocation(Request $request)
    {

        $construction = BdFeasRncPercentDetail::query()
            ->where('project_year', $request->year)
            ->where('type', 0)
            ->whereHas('BdFeasRncPercent', function ($q) use ($request) {
                return  $q->where('bd_lead_generation_id', $request->location);
            })
            ->get();
        $sale = BdFeasRncPercentDetail::query()
            ->where('project_year', $request->year)
            ->where('type', 1)
            ->whereHas('BdFeasRncPercent', function ($q) use ($request) {
                return  $q->where('bd_lead_generation_id', $request->location);
            })
            ->get();


        $response = [
            'construction'  => $construction,
            'sale'          => $sale,
        ];

        return response()->json($response);
    }

    public function getFloor($project_id)
    {
        $floors = BoqFloorProject::with('floor')->where('project_id', $project_id)->get()
            // ->pluck('floor.name','boq_floor_project_id')
        ;
        return response()->json($floors);
    }
}
