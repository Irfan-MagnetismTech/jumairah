<?php

namespace App\Http\Controllers;

use App\Materialcategory;
use App\CurrentStock;
use App\Purchase;
use App\PurchaseDetail;
use App\Material;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Spatie\Permission\Traits\HasRoles;

class InventoryReportController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:inventoryReport-list|inventoryReport-create|inventoryReport-edit|inventoryReport-delete', ['only' => ['index','show']]);
        $this->middleware('permission:inventoryReport-create', ['only' => ['create','store']]);
        $this->middleware('permission:inventoryReport-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:inventoryReport-delete', ['only' => ['destroy']]);
    }
//    public function availableStock()
//    {
//        $data = Purchase::latest()->get();
//        return  PDF::loadView('inventoryReports.availableStock')->stream('logPdf.pdf');
//    }
    public function suppStockSearch()
    {
        $items = Material::orderBy('name')->pluck('name', 'id');
        $suppliers = Supplier::orderBy('name')->pluck('name', 'id');
        return view('inventoryReports.suppStockSearch', compact('suppliers','items'));
    }
    public function supplierStock(Request $request){


        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : null;
        $tillDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : null;

        $suppliers= Purchase::
            where('supplier_id', $request->supplier_id)
            ->whereBetween('date', [$fromDate, $tillDate])
            ->get();
        //dd($suppliers);
       return  PDF::loadView('inventoryReports.supplierStock',compact('suppliers'))->stream('logPdf.pdf');
       // return view('inventoryReports.supplierStock',compact('suppliers'));
    }

    public function currentInventoryList()
    {
        $category=request()->category;
        //dd($category);

        $datas=CurrentStock::whereHas('rawMaterial',function ($q)use ($category){
                $q->where('category_id','like',"%$category%");
            })

            ->latest()->paginate(10);
        $categories=Materialcategory::orderBy('name')->pluck('name', 'id');

        //dd($datas);


        return view('inventoryReports.availableStockSearch', compact('category','datas','categories'));
    }
    public function currentstockPdf( ){
       // return 'yy';

        $category=request()->category;

        $datas=CurrentStock::whereHas('rawMaterial',function ($q)use ($category){
            $q->where('category_id','like',"%$category%");
        })->latest()->paginate(10);
        $categories=Materialcategory::orderBy('name')->pluck('name', 'id');
        return  PDF::loadView('inventoryReports.currentstockPdf',compact('categories','datas'))->stream('currentstockPdf.pdf');

    }



    public function minimumStock(){
        $categories=Materialcategory::orderBy('name')->pluck('name', 'id');
        return view('inventoryReports.minimumStock', compact('categories'));

    }
    public function minimumStockPDF(Request $request){
        $data= PurchaseDetail::all();
       return  PDF::loadView('inventoryReports.minimumStockPDF')->stream('logPdf.pdf');

//        $materialcategories=Materialcategory::orderBy('name')->pluck('name', 'id');
        //return view('inventoryReports.minimumStockPDF');

    }
}
