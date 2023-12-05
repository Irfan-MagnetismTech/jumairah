<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;

use App\Bank;
use App\CurrentStock;
use App\LcCostHead;
use App\Procurement\Purchase;
use App\PurchaseOrder;
use App\Procurement\Material;
use App\Procurement\Supplier;
use App\SupplierPayment;
use App\Procurement\Unit;
use App\Warehouse;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Controllers\TestController;

class PurchaseController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:purchase-list|purchase-create|purchase-edit|purchase-delete', ['only' => ['index','show']]);
        $this->middleware('permission:purchase-create', ['only' => ['create','store']]);
        $this->middleware('permission:purchase-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:purchase-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $user = Auth::user();
        $sectionId = Session::get('section_id');
        if($user->hasRole(['super-admin','admin'])) { 
            $allData = Purchase::with('purchaseDetails')->where('purchase_type','local')->where('section_id',$sectionId)->latest()->get();
        }else{
            $allData = Purchase::with('purchaseDetails')->where('purchase_type','local')->where('section_id',$user->section_id)->latest()->get();
        }
        
       // $allData = Purchase::with('purchaseDetails')->where('purchase_type','local')->latest()->get();
        return view('procurement.purchases.index', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $supplier = Supplier::orderBy('name')->pluck('name','id');
        $bank = Bank::orderBy('name')->pluck('name','id');
        $rawItems = Material::orderBy('name')->pluck('name','id');
        $units = Unit::orderBy('name')->pluck('name','id');
        $costHeads= LcCostHead::orderBy('name')->pluck('name','id');
//        $warehouse =  Warehouse::orderBy('name')->pluck('name','id');
        return view('procurement.purchases.create', compact('formType','rawItems','supplier','bank','costHeads','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $user = Auth::user();
            $sectionId = Session::get('section_id');
            $data = $request->except('raw_material_id','quantity','unit_id','unite_price','totalPrice');
            if($user->hasRole(['super-admin','admin'])) {
                $data['section_id'] = $sectionId;
            }else
            {
                $data['section_id'] = $user->section_id;
            }
            $data['user_id'] =  Auth()->id();
            $data['purchase_type'] =  'local';
            $purchaseDtl = array();
            $currentStock = array();
            foreach($request->raw_material_id as  $key => $item){
                $purchaseDtl[] = [
                    'raw_material_id' => $request->raw_material_id[$key],
                    'purchase_order_detail_id' => $request->purchase_order_detail_id[$key],
//                    'unit_id' => $request->unit_id[$key],
                    'quantity' => $request->quantity[$key],
                    'unite_price' => $request->unite_price[$key],
                    'totalPrice' => $request->totalPrice[$key],
                ];
    //start current stock operation
                $currentStockQnt = CurrentStock::where('raw_material_id',$request->raw_material_id[$key])->first();
                if (!empty($currentStockQnt)){
                    $newQuantity = $currentStockQnt->quantity + $request->quantity[$key];
                }else{
                    $newQuantity = $request->quantity[$key];
                }
                $currentStock = array(
                    'raw_material_id' => $request->raw_material_id[$key],
                    'quantity' => $newQuantity,
                    );
                if (!empty($currentStockQnt)){
                    CurrentStock::where('raw_material_id',$request->raw_material_id[$key])->update(['quantity'=>$newQuantity]) ;
                }else{
                    CurrentStock::create($currentStock);
                }
            } // end   current stock operation
//            TestController::myFunction($purchaseDtl);

            $paymentData = $request->only('supplier_id','pay_amount','date');
            DB::transaction(function()use($data, $paymentData,$purchaseDtl){
                $purchaseID = Purchase::create($data);
                $purchaseID->supplierPayment()->create($paymentData);
                $purchaseID->purchaseDetails()->createMany($purchaseDtl);
            });
            return redirect()->route('purchases.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

//    public function myFunction($data)
//    {
//        dd($data);
//    }

    public function show(Purchase $purchase) 
    {
        return view('procurement.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $formType = "edit";
        $supplier = Supplier::orderBy('name')->pluck('name','id');
        $bank = Bank::orderBy('name')->pluck('name','id');
        $rawItems = Material::orderBy('name')->pluck('name','id'); 
        $units = Unit::orderBy('name')->pluck('name','id');
        $costHeads= LcCostHead::orderBy('name')->pluck('name','id');
        $warehouse =  Warehouse::orderBy('name')->pluck('name','id');
        $netAmount = $purchase->total_amount - $purchase->vat - $purchase->discount;
        $dueAmount = $purchase->total_amount - $purchase->vat - $purchase->discount;
        $payAmount = SupplierPayment::where('purchase_id',$purchase->id)->groupBy('supplier_id')->sum('pay_amount');

        $poQnt = PurchaseOrder::where('id',$purchase->purchase_order_id)->first();
//        dd($poQnt->purchaseOrderDetails);

        return view('procurement.purchases.create', compact('formType','rawItems','supplier','bank','costHeads','units','warehouse',
                        'purchase','netAmount','dueAmount','payAmount','poQnt'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        try{
            $data = $request->except('raw_material_id','quantity','unit_id','unite_price','totalPrice');
            $data['user_id'] =  Auth()->id();
            $data['purchase_type'] =  'local';
            $purchaseDtl = array();
            foreach($request->raw_material_id as  $key => $item){
                $purchaseDtl[] = [
                    'raw_material_id' => $request->raw_material_id[$key],
                    'purchase_order_detail_id' => $request->purchase_order_detail_id[$key],
//                    'unit_id' => $request->unit_id[$key],
                    'quantity' => $request->quantity[$key],
                    'unite_price' => $request->unite_price[$key],
                    'totalPrice' => $request->totalPrice[$key],
                ];
            }
            DB::transaction(function()use($purchase, $data, $purchaseDtl){
                $purchase->update($data);
                $purchase->purchaseDetails()->delete();
                $purchase->purchaseDetails()->createMany($purchaseDtl);
            });
            return redirect()->route('purchases.create')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->route('purchases.create')->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        //
    }

    public function purchasepdf($id)
    {
        $purchasepdf = Purchase::where('id', $id)->firstOrFail();
       //dd($purchasepdf);

//        return view('purchaseOrders.purchaseorderpdf', compact('purchaseOrder'));

        return  PDF::loadview('procurement.purchases.purchasepdf', compact('purchasepdf'))->stream('purchase.pdf');
    }
}
