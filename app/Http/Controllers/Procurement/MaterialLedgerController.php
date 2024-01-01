<?php

namespace App\Http\Controllers\Procurement;

use App\Project;
use Illuminate\Http\Request;
use App\Procurement\MovementIn;
use App\Procurement\StockHistory;
use App\Procurement\NestedMaterial;
use App\Http\Controllers\Controller;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\Materialmovement;
use Barryvdh\DomPDF\Facade as PDF;

class MaterialLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:stock-reports', ['only' => ['index', 'projectList', 'Getmaterial', 'GetMaterialLedger', 'GetMaterialLedgerPdf']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('procurement.stockledger.index');
    }

    public function projectList()
    {
        $datas = StockHistory::with('costCenter')
            ->orderBy('cost_center_id')
            ->latest()
            ->get()
            ->map(function ($item, $key) {
                return [
                    'cost_center_id' => $item->cost_center_id,
                    'cost_center_name' => $item->costCenter->name,
                ];
            })
            ->groupBy('cost_center_id')
            ->toArray();
        return view('procurement.stockledger.projectlist', compact('datas'));
    }

    public function Getmaterial($cost_center_id)
    {
        $datas = StockHistory::with('nestedMaterial')
            ->where('cost_center_id', $cost_center_id)
            ->orderBy('material_id')
            ->latest()
            ->get()
            ->map(function ($item, $key) {
                return [
                    'material_id' => $item->material_id,
                    'material_name' => $item->nestedMaterial->name,
                ];
            })
            ->groupBy('material_id')
            ->toArray();

        return view('procurement.stockledger.materiallist', compact('datas', 'cost_center_id'));
    }

    public function GetMaterialLedger($cost_center_id, $material_id)
    {
        $receive_from_purchase = StockHistory::query()
            ->with('MaterialReceive')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->whereNotNull('material_receive_report_id')
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);

        $issued_for_work_site = StockHistory::query()
            ->with('storeIssue')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->whereNotNull('store_issue_id')
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);
        $data_groups = StockHistory::query()
            ->with('nestedMaterial', 'costCenter')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');


        $movement_In = StockHistory::with('movementin')
            ->where('stockable_type', MovementIn::class)
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);
        $movement_out = StockHistory::with('movementout')
            ->where('stockable_type', Materialmovement::class)
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);

        $depth = (int) NestedMaterial::withDepth()->find($material_id)->depth;
        if ($depth >= 3) {
            $material_depth = NestedMaterial::find($material_id)->parent->id;
        } else {
            $material_depth = $material_id;
        }

        $TotalEstimatedQuantity = BoqSupremeBudget::where('material_id', $material_depth)
            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                return $query->where('id', $cost_center_id);
            })
            ->get()
            ->sum('quantity');
        // dd($TotalEstimatedQuantity,$data_groups,$receive_from_purchase,$issued_for_work_site,$movement_In,$movement_out);
        return view('procurement.stockledger.index', compact('cost_center_id', 'material_id', 'TotalEstimatedQuantity', 'movement_In', 'movement_out', 'data_groups', 'issued_for_work_site', 'receive_from_purchase'));
    }

    public function GetMaterialLedgers(Request $request)
    {
        $reportType = $request->reportType;
        $project_name = $request->project_name;
        $project_id = $request->project_id;

        // $sells = Sell::with('sellClient.client', 'apartment.project', 'salesCollections')
        //     ->when($project_id, function ($q) use ($project_id) {
        //         $q->whereHas('apartment.project', function ($q) use ($project_id) {
        //             $q->where('project_id', $project_id);
        //         });
        //     })
        //     ->orderBy('sell_date', 'desc')
        //     ->withSum('salesCollections as totalCollectedAmount', 'received_amount')

        //     ->when($dateType, function ($q) use ($dateType, $fromDate, $tillDate) {
        //         return $q->dateRange('sell_date', $dateType, $fromDate, $tillDate);
        //     })
        //     ->get();

        //    return $sells;

        if ($reportType == 'pdf') {
            // return  PDF::loadview('sales.projects.projectreportpdf', compact('sells'))->setPaper('a4', 'landscape')->stream('projectreport.pdf');
        } else {
            return  view('procurement.materialLedger.index', compact('project_id', 'project_name'));
        }
    }

    public function GetMaterialLedgerPdf($cost_center_id, $material_id)
    {
        $receive_from_purchase = StockHistory::query()
            ->with('MaterialReceive')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->whereNotNull('material_receive_report_id')
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);

        $issued_for_work_site = StockHistory::query()
            ->with('storeIssue')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->whereNotNull('store_issue_id')
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);
        $data_groups = StockHistory::query()
            ->with('nestedMaterial')
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');

        $movement_In = StockHistory::with('movementin')
            ->where('stockable_type', MovementIn::class)
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);

        $movement_out = StockHistory::with('movementout')
            ->where('stockable_type', Materialmovement::class)
            ->where('cost_center_id', $cost_center_id)
            ->where('material_id', $material_id)
            ->get()
            ->groupBy('date')
            ->map(fn ($item) => [
                'sum'           => $item->sum('quantity'),
                'item'          => $item
            ]);

        // $TotalEstimatedQuantity = BoqSupremeBudget::where('material_id', $material_id)
        //         ->whereHas('costCenter', function ($query) use ($cost_center_id) {
        //             return $query->where('id',$cost_center_id);
        //         })
        //         ->get()
        //         ->sum('quantity');
        $depth = (int) NestedMaterial::withDepth()->find($material_id)->depth;
        if ($depth >= 3) {
            $material_depth = NestedMaterial::find($material_id)->parent->id;
        } else {
            $material_depth = $material_id;
        }

        $TotalEstimatedQuantity = BoqSupremeBudget::where('material_id', $material_depth)
            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                return $query->where('id', $cost_center_id);
            })
            ->get()
            ->sum('quantity');

        // return view('procurement.stockledger.pdf',compact('cost_center_id','material_id','TotalEstimatedQuantity','movement_In','movement_out','data_groups','issued_for_work_site','receive_from_purchase'));
        return PDF::loadview('procurement.stockledger.pdf', compact('cost_center_id', 'material_id', 'TotalEstimatedQuantity', 'movement_In', 'movement_out', 'data_groups', 'issued_for_work_site', 'receive_from_purchase'))
            ->setPaper('8.5x14', 'landscape')
            ->stream('material_ledger.pdf');
    }
}
