<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Procurement\StockHistory;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\MovementIn;
use App\Procurement\Materialmovement;
use Barryvdh\DomPDF\Facade as PDF;

class MaterialInventoryReportController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:stock-reports', ['only' => ['projectList','yearList', 'monthList', 'GetReportAll', 'GetReport', 'mirPdf']]);
    }


    public function projectList()
    {
        $datas = StockHistory::with('costCenter')
                ->orderBy('cost_center_id')
                ->latest()
                ->get()
                ->map(function($item, $key){
                    return [
                        'cost_center_id'=>$item->cost_center_id,
                        'cost_center_name'=>$item->costCenter->name,
                    ];
                })
                ->groupBy('cost_center_id')
                ->toArray();
        return view('procurement.material-inventory-report.projectlist', compact('datas'));
    }

    public function yearList($cost_center_id){
            $years = StockHistory::query()
            ->where('cost_center_id',$cost_center_id)
            ->select(\DB::raw('year(created_at) as year'))
            ->groupBy(\DB::raw('year(created_at)'))
            ->pluck('year');

        return view('procurement.material-inventory-report.yearList',compact('years','cost_center_id'));

    }

    public function monthList($cost_center_id,$year){
        $months = StockHistory::query()
        ->where('cost_center_id',$cost_center_id)
        ->whereYear('created_at',$year)
        ->select(\DB::raw('month(created_at) as month'))
        ->groupBy(\DB::raw('month(created_at)'))
        ->pluck('month');

    return view('procurement.material-inventory-report.monthList',compact('months','year','cost_center_id'));

}

public function GetReportAll($cost_center_id){

    $opening_inventory =  StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy('material_id');

    $total_purchase = StockHistory::query()
                    ->where('cost_center_id',$cost_center_id)
                    ->whereNotNull('material_receive_report_id')
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');
    $total_movementin = StockHistory::query()
                    ->where('stockable_type', MovementIn::class)
                    ->where('cost_center_id',$cost_center_id)
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');


    $total_movementout = StockHistory::query()
                    ->where('stockable_type', Materialmovement::class)
                    ->where('cost_center_id',$cost_center_id)
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');
    /*for Net Cumulative Received start */
    // $material_id = StockHistory::query()
    //                 ->with('nestedMaterial')
    //                 ->where('cost_center_id',$cost_center_id)
    //                 ->get()
    //                 ->map(function($item){
    //                     $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
    //                     if($depth >= 3){
    //                         return NestedMaterial::find($item->material_id)->parent->id;
    //                     }else{
    //                         return $item->material_id;
    //                     }
    //             })->unique();
    //             // dd($material_id);
    // $TotalEstimatedQuantity = BoqSupremeBudget::whereIn('material_id', $material_id)
    //                         ->whereHas('costCenter', function ($query) use ($cost_center_id) {
    //                             return $query->where('id',$cost_center_id);
    //                         })
    //                         ->get()
    //                         ->groupBy('material_id')
    //                         ->map(function($item){
    //                             return $item->sum('quantity');
    //                         });
    $TotalEstimatedQuantity = StockHistory::query()
                    ->with('nestedMaterial')
                    ->where('cost_center_id',$cost_center_id)
                    ->get()
                    ->mapWithKeys(function($item) use ($cost_center_id){
                        $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
                        if($depth >= 3){
                            $data = BoqSupremeBudget::where('material_id', NestedMaterial::find($item->material_id)->parent->id)
                            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                return $query->where('id',$cost_center_id);
                            })
                            ->sum('quantity');

                            $TotalEstimatedQuantity[$item->material_id] = ['value' => $data ,'parent_id'=>NestedMaterial::find($item->material_id)->parent->id];
                            return $TotalEstimatedQuantity;
                        }else{

                            $data = BoqSupremeBudget::where('material_id', $item->material_id)
                            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                return $query->where('id',$cost_center_id);
                            })
                            ->sum('quantity');
                            $TotalEstimatedQuantity[$item->material_id] = ['value' => $data ,'parent_id'=>$item->material_id];
                            return $TotalEstimatedQuantity;
                        }
                });

    // $TotalEstimatedQuantity = BoqSupremeBudget::whereIn('material_id', $material_id)
    //                         ->whereHas('costCenter', function ($query) use ($cost_center_id) {
    //                             return $query->where('id',$cost_center_id);
    //                         })
    //                         ->get()
    //                         ->groupBy('material_id')
    //                         ->map(function($item){
    //                             return $item->sum('quantity');
    //                         });
    /*for Net Cumulative Received start */
    $total_sale = StockHistory::query()
                    ->where('cost_center_id',$cost_center_id)
                    ->whereNotNull('store_issue_id')
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');

    $cumulitive_receive =  StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->where(function($q){
                                $q->whereNotNull('material_receive_report_id')->orWhere('stockable_type', MovementIn::class);
                            })
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');
    $cumulitive_issue = StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->where(function($q){
                            $q->whereNotNull('store_issue_id')->orWhere('stockable_type', Materialmovement::class);
                        })
                        ->groupBy('material_id')
                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                        ->get()
                        ->groupBy('material_id');

    $totals = StockHistory::query()
            ->with('nestedMaterial')
            ->where('cost_center_id',$cost_center_id)
            ->join('nested_materials', 'nested_materials.id', '=', 'stock_histories.material_id')
            ->select('stock_histories.*', 'nested_materials.parent_id')
            ->orderBy('nested_materials.id')
            ->orderBy('nested_materials.parent_id')
            ->get()
            ->groupBy('material_id');



    $qr =[
        'cost_center_id' => $cost_center_id
    ];

    return view('procurement.material-inventory-report.stockreport',compact( 'qr','total_movementout','total_movementin','TotalEstimatedQuantity','totals','cost_center_id','opening_inventory','cumulitive_receive','cumulitive_issue','total_purchase','total_sale'));

}

public function GetReport(Request $request){
        $cost_center_id = $request->cost_center_id;
        $fromdate = $this->formatDate($request->fromdate);
        $todate =  $this->formatDate($request->todate);


         $opening_inventory =  StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->orderBy('created_at','ASC')
                            ->get()
                            ->groupBy('material_id');

        // $TotalEstimatedQuantity = StockHistory::query()
        //                         ->with('costCenter.project.boqSupremeBudgets')
        //                         ->where('cost_center_id',$cost_center_id)
        //                         ->whereBetween('created_at', [$fromdate, $todate])
        //                         ->orderBy('created_at','ASC')
        //                         ->get();
        $total_purchase = StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->whereNotNull('material_receive_report_id')
                        ->whereBetween('created_at', [$fromdate, $todate])
                        ->groupBy('material_id')
                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                        ->get()
                        ->groupBy('material_id');

        $total_sale = StockHistory::query()
                    ->where('cost_center_id',$cost_center_id)
                    ->whereNotNull('store_issue_id')
                    ->whereBetween('created_at', [$fromdate, $todate])
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');
        $total_movementin = StockHistory::query()
                    ->where('stockable_type', MovementIn::class)
                    ->where('cost_center_id',$cost_center_id)
                    ->whereBetween('created_at', [$fromdate, $todate])
                    ->groupBy('material_id')
                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                    ->get()
                    ->groupBy('material_id');

        $total_movementout = StockHistory::query()
                            ->where('stockable_type', Materialmovement::class)
                            ->where('cost_center_id',$cost_center_id)
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');

        $cumulitive_receive = StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->where(function($q){
                                $q->whereNotNull('material_receive_report_id')->orWhere('stockable_type', MovementIn::class);
                            })
                            ->where('created_at', '<=' ,$todate)
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');
        $cumulitive_issue = StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->where(function($q){
                                $q->whereNotNull('store_issue_id')->orWhere('stockable_type', Materialmovement::class);
                            })
                            ->where('created_at', '<=' ,$todate)
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');
        /*for Net Cumulative Received start */
        // $material_id = StockHistory::query()
        //             ->with('nestedMaterial')
        //             ->where('cost_center_id',$cost_center_id)
        //             ->get()
        //             ->map(function($item){
        //                 $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
        //                 if($depth >= 3){
        //                     return NestedMaterial::find($item->material_id)->parent->id;
        //                 }else{
        //                     return $item->material_id;
        //                 }
        //             })->unique();

        // $TotalEstimatedQuantity = BoqSupremeBudget::whereIn('material_id', $material_id)
        //                     ->whereHas('costCenter', function ($query) use ($cost_center_id) {
        //                         return $query->where('id',$cost_center_id);
        //                     })
        //                     ->get()
        //                     ->groupBy('material_id')
        //                     ->map(function($item){
        //                         return $item->sum('quantity');
        //                     });


        $TotalEstimatedQuantity = StockHistory::query()
        ->with('nestedMaterial')
        ->where('cost_center_id',$cost_center_id)
        ->get()
        ->mapWithKeys(function($item) use ($cost_center_id){
            $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
            if($depth >= 3){
                $data = BoqSupremeBudget::where('material_id', NestedMaterial::find($item->material_id)->parent->id)
                ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                    return $query->where('id',$cost_center_id);
                })
                ->sum('quantity');

                $TotalEstimatedQuantity[$item->material_id] = ['value' => $data ,'parent_id'=>NestedMaterial::find($item->material_id)->parent->id];
                return $TotalEstimatedQuantity;
            }else{

                $data = BoqSupremeBudget::where('material_id', $item->material_id)
                ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                    return $query->where('id',$cost_center_id);
                })
                ->sum('quantity');
                $TotalEstimatedQuantity[$item->material_id] = ['value' => $data ,'parent_id'=>$item->material_id];
                return $TotalEstimatedQuantity;
            }
    });


        /*for Net Cumulative Received start */



        $totals = StockHistory::query()
        ->with('nestedMaterial')
        ->where('cost_center_id',$cost_center_id)
        ->join('nested_materials', 'nested_materials.id', '=', 'stock_histories.material_id')
            ->select('stock_histories.*', 'nested_materials.parent_id')
            ->orderBy('nested_materials.id')
            ->orderBy('nested_materials.parent_id')
            ->get()
            ->groupBy('material_id');


        $qr =[
            'cost_center_id' => $cost_center_id,
            'from_date'   => $fromdate,
            'to_date'   => $todate
        ];
    return view('procurement.material-inventory-report.stockreport',compact('qr','total_movementout','total_movementin','TotalEstimatedQuantity','cumulitive_receive','cumulitive_issue','todate','fromdate','totals','cost_center_id','opening_inventory','total_purchase','total_sale'));
}




public function mirPdf(Request $request){
    $cost_center_id = $request->attn['cost_center_id'];

    if(isset($request->attn['from_date']) && $request->attn['to_date']){
                $fromdate = $request->attn['from_date'];
                $todate = $request->attn['to_date'];

                $opening_inventory =  StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->whereBetween('created_at', [$fromdate, $todate])
                        ->orderBy('created_at','ASC')
                        ->get()
                        ->groupBy('material_id');

                $TotalEstimatedQuantity = StockHistory::query()
                            ->with('costCenter.project.boqSupremeBudgets')
                            ->where('cost_center_id',$cost_center_id)
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->orderBy('created_at','ASC')
                            ->get();
                $total_purchase = StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->whereNotNull('material_receive_report_id')
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');

                $total_sale = StockHistory::query()
                            ->where('cost_center_id',$cost_center_id)
                            ->whereNotNull('store_issue_id')
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');
                $total_movementin = StockHistory::query()
                            ->where('stockable_type', MovementIn::class)
                            ->where('cost_center_id',$cost_center_id)
                            ->whereBetween('created_at', [$fromdate, $todate])
                            ->groupBy('material_id')
                            ->select(\DB::raw('sum(quantity) as total'),'material_id')
                            ->get()
                            ->groupBy('material_id');

                $total_movementout = StockHistory::query()
                        ->where('stockable_type', Materialmovement::class)
                        ->where('cost_center_id',$cost_center_id)
                        ->whereBetween('created_at', [$fromdate, $todate])
                        ->groupBy('material_id')
                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                        ->get()
                        ->groupBy('material_id');

                $cumulitive_receive = StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->where(function($q){
                            $q->whereNotNull('material_receive_report_id')->orWhere('stockable_type', MovementIn::class);
                        })
                        ->where('created_at', '<=' ,$todate)
                        ->groupBy('material_id')
                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                        ->get()
                        ->groupBy('material_id');
                $cumulitive_issue = StockHistory::query()
                        ->where('cost_center_id',$cost_center_id)
                        ->where(function($q){
                            $q->whereNotNull('store_issue_id')->orWhere('stockable_type', Materialmovement::class);
                        })
                        ->where('created_at', '<=' ,$todate)
                        ->groupBy('material_id')
                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                        ->get()
                        ->groupBy('material_id');
                // /*for Net Cumulative Received start */
                // $material_id = StockHistory::query()
                // ->with('nestedMaterial')
                // ->where('cost_center_id',$cost_center_id)
                // ->get()
                // ->map(function($item){
                //     $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
                //     if($depth >= 3){
                //         return NestedMaterial::find($item->material_id)->parent->id;
                //     }else{
                //         return $item->material_id;
                //     }
                // })->unique();

                // $TotalEstimatedQuantity = BoqSupremeBudget::whereIn('material_id', $material_id)
                //         ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                //             return $query->where('id',$cost_center_id);
                //         })
                //         ->get()
                //         ->groupBy('material_id')
                //         ->map(function($item){
                //             return $item->sum('quantity');
                //         });

                $TotalEstimatedQuantity = StockHistory::query()
                                                    ->with('nestedMaterial')
                                                    ->where('cost_center_id',$cost_center_id)
                                                    ->get()
                                                    ->mapWithKeys(function($item) use ($cost_center_id){
                                                        $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
                                                        if($depth >= 3){
                                                            $data = BoqSupremeBudget::where('material_id', NestedMaterial::find($item->material_id)->parent->id)
                                                                                    ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                                                    return $query->where('id',$cost_center_id);
                                                                    })
                                                                    ->sum('quantity');

                                                            $TotalEstimatedQuantity[$item->material_id] = [
                                                                'value' => $data ,
                                                                'parent_id'=>NestedMaterial::find($item->material_id)->parent->id
                                                            ];
                                                            return $TotalEstimatedQuantity;
                                                        }else{

                                                            $data = BoqSupremeBudget::where('material_id', $item->material_id)
                                                                                ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                                                        return $query->where('id',$cost_center_id);
                                                                    })
                                                                    ->sum('quantity');
                                                            $TotalEstimatedQuantity[$item->material_id] = [
                                                                'value' => $data ,
                                                                'parent_id'=>$item->material_id
                                                            ];
                                                            return $TotalEstimatedQuantity;
                                                        }
                                                    });





                /*for Net Cumulative Received start */



                $totals = StockHistory::query()
                                    ->with('nestedMaterial')
                                    ->where('cost_center_id',$cost_center_id)
                                    ->join('nested_materials', 'nested_materials.id', '=', 'stock_histories.material_id')
                                    ->select('stock_histories.*', 'nested_materials.parent_id')
                                    ->orderBy('nested_materials.parent_id')
                                    ->get()
                                    ->groupBy('material_id');


    }else{
        $opening_inventory =  StockHistory::query()
                                            ->where('cost_center_id',$cost_center_id)
                                            ->orderBy('created_at')
                                            ->get()
                                            ->groupBy('material_id');

        $total_purchase = StockHistory::query()
                                        ->where('cost_center_id',$cost_center_id)
                                        ->whereNotNull('material_receive_report_id')
                                        ->groupBy('material_id')
                                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                        ->get()
                                        ->groupBy('material_id');
        $total_movementin = StockHistory::query()
                                        ->where('stockable_type', MovementIn::class)
                                        ->where('cost_center_id',$cost_center_id)
                                        ->groupBy('material_id')
                                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                        ->get()
                                        ->groupBy('material_id');


        $total_movementout = StockHistory::query()
                                        ->where('stockable_type', Materialmovement::class)
                                        ->where('cost_center_id',$cost_center_id)
                                        ->groupBy('material_id')
                                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                        ->get()
                                        ->groupBy('material_id');
        /*for Net Cumulative Received start */
        // $material_id = StockHistory::query()
        //     ->with('nestedMaterial')
        //     ->where('cost_center_id',$cost_center_id)
        //     ->get()
        //     ->map(function($item){
        //         $depth = (int) NestedMaterial::withDepth()->find($item->material_id)->depth;
        //         if($depth >= 3){
        //             return NestedMaterial::find($item->material_id)->parent->id;
        //         }else{
        //             return $item->material_id;
        //         }
        //     })->unique();
        // $TotalEstimatedQuantity = BoqSupremeBudget::whereIn('material_id', $material_id)
        //             ->whereHas('costCenter', function ($query) use ($cost_center_id) {
        //                 return $query->where('id',$cost_center_id);
        //             })
        //             ->get()
        //             ->groupBy('material_id')
        //             ->map(function($item){
        //                 return $item->sum('quantity');
        //             });


        $TotalEstimatedQuantity = StockHistory::query()
                                            ->with('nestedMaterial')
                                            ->where('cost_center_id',$cost_center_id)
                                            ->get()
                                            ->mapWithKeys(function($item) use ($cost_center_id){
                                                $depth = (int) NestedMaterial::withDepth()
                                                                            ->find($item->material_id)
                                                                            ->depth;
                                                if($depth >= 3){
                                                    $data = BoqSupremeBudget::where('material_id', NestedMaterial::find($item->material_id)->parent->id)
                                                                            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                                                    return $query->where('id',$cost_center_id);
                                                                })
                                                                ->sum('quantity');

                                                    $TotalEstimatedQuantity[$item->material_id] = [
                                                        'value' => $data ,
                                                        'parent_id'=>NestedMaterial::find($item->material_id)->parent->id
                                                    ];
                                                    return $TotalEstimatedQuantity;
                                                }else{

                                                    $data = BoqSupremeBudget::where('material_id', $item->material_id)
                                                                            ->whereHas('costCenter', function ($query) use ($cost_center_id) {
                                                                                return $query->where('id',$cost_center_id);
                                                                            })
                                                                            ->sum('quantity');
                                                    $TotalEstimatedQuantity[$item->material_id] = [
                                                        'value' => $data ,
                                                        'parent_id'=>$item->material_id
                                                    ];
                                                    return $TotalEstimatedQuantity;
                                                }
                                        });


        /*for Net Cumulative Received start */
        $total_sale = StockHistory::query()
                                    ->where('cost_center_id',$cost_center_id)
                                    ->whereNotNull('store_issue_id')
                                    ->groupBy('material_id')
                                    ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                    ->get()
                                    ->groupBy('material_id');

        $cumulitive_receive =  StockHistory::query()
                                        ->where('cost_center_id',$cost_center_id)
                                        ->where(function($q){
                                            $q->whereNotNull('material_receive_report_id')
                                                ->orWhere('stockable_type', MovementIn::class);
                                        })
                                        ->groupBy('material_id')
                                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                        ->get()
                                        ->groupBy('material_id');
        $cumulitive_issue = StockHistory::query()
                                        ->where('cost_center_id',$cost_center_id)
                                        ->where(function($q){
                                            $q->whereNotNull('store_issue_id')
                                                ->orWhere('stockable_type', Materialmovement::class);
                                        })
                                        ->groupBy('material_id')
                                        ->select(\DB::raw('sum(quantity) as total'),'material_id')
                                        ->get()
                                        ->groupBy('material_id');

                $totals = StockHistory::query()
                                        ->with('nestedMaterial')
                                        ->where('cost_center_id',$cost_center_id)
                                        ->join('nested_materials', 'nested_materials.id', '=', 'stock_histories.material_id')
                                        ->select('stock_histories.*', 'nested_materials.parent_id')
                                        ->orderBy('nested_materials.id')
                                        ->orderBy('nested_materials.parent_id')
                                        ->get()
                                        ->groupBy('material_id');
                $todate = null;
                $fromdate = null;


    }
    // return view('procurement.material-inventory-report.pdf',compact('total_movementout','total_movementin','TotalEstimatedQuantity','cumulitive_receive','cumulitive_issue','todate','fromdate','totals','cost_center_id','opening_inventory','total_purchase','total_sale'));
    return PDF::loadview('procurement.material-inventory-report.pdf',compact('total_movementout','total_movementin','TotalEstimatedQuantity','cumulitive_receive','cumulitive_issue','todate','fromdate','totals','cost_center_id','opening_inventory','total_purchase','total_sale'))
                ->setPaper('legal', 'landscape')
                ->stream('mir.pdf');

}
private function formatDate(string $date): string
{
    // dd(substr( date_format(date_create($date),"Y-m-d"), 0));
    // dd(date('Y-m-d', strtotime($date)));
   return \Carbon\Carbon::parse($date)->format('Y-m-d');
}

}
