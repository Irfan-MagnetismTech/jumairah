<?php

namespace App\Http\Controllers\Procurement;

use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\Storeissuedetails;
use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;

class ProcurementReportController extends Controller
{


    public function purchaseorderreport()
    {
//        return view('procurement.purchaseOrders.purchaseorderreportpdf');

        return PDF::loadview('procurement.purchaseOrders.purchaseorderreportpdf')->stream('Purchase Order.pdf');
    }
    public function requisitionreport()
    {
//        return view('procurement.requisitions.requisitionreportpdf');

        return PDF::loadview('procurement.requisitions.requisitionreportpdf')->stream('Requisition Report.pdf');
    }
    public function ioureport()
    {
//        return view('procurement.ious.ioureportpdf');

        return PDF::loadview('procurement.ious.ioureportpdf')->stream('Iou Report.pdf');
    }
    public function advanceadjustmentreport()
    {
//        return view('procurement.advanceadjustments.advanceadjustmentreportpdf');

        return PDF::loadview('procurement.advanceadjustments.advanceadjustmentreportpdf')->stream('Advance Adjustment.pdf');
    }
    public function csreport()
    {
//        return view('procurement.comparativestatements.csreportpdf');

        return PDF::loadview('procurement.comparativestatements.csreportpdf')->stream('CS Report.pdf');
    }
    public function storeissuenotereport()
    {
//        return view('procurement.storeissues.storeissuereportpdf');

        return PDF::loadview('procurement.storeissues.storeissuereportpdf')->stream('CS Report.pdf');
    }

    public function supplierbillreport()
    {
//        return view('procurement.supplierbills.supplierbillreportpdf');

        return PDF::loadview('procurement.supplierbills.supplierbillreportpdf')->stream('CS Report.pdf');
    }

    public function floorWiseConsumption() {
        $project_id = request('project_id');
        $floors = BoqFloorProject::where('project_id', $project_id)->get()->pluck('floor.name','boq_floor_project_id');
        $boq_supreme_budget_data = BoqSupremeBudget::
            when(!empty(request('floor_id')), function($query){
                $query->where('floor_id', request('floor_id'));
            })
            ->where('project_id', $project_id)
            ->get()->groupBy('floor_id')
            ->map(function($items , $key) use ($project_id){ 
                $items->map(function($item) use($key, $project_id){
                    $storeIssue = Storeissuedetails::whereHas('storeissue.costCenter', function($query) use ($project_id){
                                $query->where('project_id', $project_id);
                            })->whereHas('boqFloor.boqFloorProjects', function($q) use ($key){
                                $q->where('boq_floor_project_id', $key);
                            })
                            ->whereHas('nestedMaterials',function($q) use ($item){
                                $q->where('material_id',$item->material_id);
                            })
                            ->sum('issued_quantity');
                    $item['issued_quantity'] = $storeIssue;
                    return $item;
                }); 
                $items->sortBy('nestedMaterial.name');
                return $items;
            });
            
        $projectName = Project::where('id', $project_id)->first();
        $page = request('page');
        $sl = (!empty($page) && $page != 1) ? (($page - 1) * 15)+1 : 1 ;
        // dd($boq_supreme_budget_data->toArray());

        return view('procurement.floorWiseConsumption', compact('projectName','floors',
                'boq_supreme_budget_data','project_id','sl'));
    }

}
