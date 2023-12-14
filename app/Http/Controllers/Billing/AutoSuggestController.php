<?php

namespace App\Http\Controllers\Billing;

use App\Billing\WorkCs;
use App\Billing\WorkCsSupplier;
use App\Billing\WorkCsSupplierRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutoSuggestController extends Controller
{
    public function workCSRefAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = WorkCs::limit(5)->get(['reference_no', 'id']);
        }else{
            $items = WorkCs::where('reference_no', 'like', '%' .$search . '%')->limit(10)->get();
        }
        $response = array();
        foreach($items as $item){
            $response[] = [
                "label"=>$item->reference_no,
                "value"=>$item->id,
                "project_id"=>$item->project_id,
                "project_name"=>$item->project->name,
                "cs_type"=>$item->cs_type,
                "description"=>$item->description,
                "involvement"=>$item->involvement,
                "is_for_all"=>$item->is_for_all
            ];
        }
        return response()->json($response);
    }

    public function loadWorkCsSupplier($cs_id)
    {
        return WorkCsSupplier::with('supplier:id,name')->where('work_cs_id', $cs_id)->where('is_checked', true)->get(['id', 'work_cs_id', 'supplier_id']);
    }

    public function loadWorkCsRates($cs_id, $supplier_id)
    {
        // dd($cs_id, $supplier_id);
        $WorkCsSupplierRate = WorkCsSupplierRate::with('workCsLine')->where('work_cs_id', $cs_id)->where('work_cs_supplier_id', $supplier_id)->get();

        $workRate = $WorkCsSupplierRate->map(function($q){
            return $myData = [
                'work_level' => $q->workCsLine->work_level,
                'work_desciption' => $q->workCsLine->work_description,
                'work_quantity' => $q->workCsLine->work_quantity,
                'work_unit' => $q->workCsLine->work_unit,
                'work_price' => $q->price,
            ];
        });
        return $workRate;
    }



}
