<?php

namespace App\Http\Controllers\BD;

use App\Accounts\Account;
use App\BD\ScrapSale;
use App\BD\ScrapSaleDetail;
use Illuminate\Http\Request;
use App\Procurement\StockHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\QueryException;

class ScrapSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-scrap-sale-view|bd-scrap-sale-create|bd-scrap-sale-edit|bd-scrap-sale-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-scrap-sale-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-scrap-sale-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-scrap-sale-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scrap_sale = ScrapSale::latest()->get();
        return view('bd.scrap-sale.index',compact('scrap_sale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('bd.scrap-sale.create',compact('formType'));
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
            $requestData = $request->only('gate_pass', 'scrap_cs_id', 'cost_center_id','applied_date','supplier_id','grand_total','sgs');
            $requestData['applied_by']  = auth()->id();
            $requestDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requestDetailData[] = [
                    'material_id'   =>  $request->material_id[$key],
                    'rate'      =>  $request->rate[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key]
                ];
            }

           DB::transaction(function()use($requestData, $requestDetailData){
               $scrapSale = ScrapSale::create($requestData);
               $scrapSale->scrapSaleDetail()->createMany($requestDetailData);
           });

            return redirect()->route('scrapSale.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
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
    public function edit(ScrapSale $scrapSale)
    {
        $formType = 'edit';
        return view('bd.scrap-sale.create',compact('formType','scrapSale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScrapSale $scrapSale)
    {
        try{
            $requestData = $request->only('gate_pass', 'scrap_cs_id', 'cost_center_id','applied_date','supplier_id','grand_total','sgs');
            $requestData['applied_by']  = auth()->id();
            $requestDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requestDetailData[] = [
                    'material_id'   =>  $request->material_id[$key],
                    'rate'      =>  $request->rate[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key]
                ];
            }

           DB::transaction(function()use($requestData, $requestDetailData,$scrapSale){
               $scrapSale->update($requestData);
               $scrapSale->scrapSaleDetail()->delete();
               $scrapSale->scrapSaleDetail()->createMany($requestDetailData);
           });

            return redirect()->route('scrapSale.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScrapSale $scrapSale)
    {
        try{
            $scrapSale->delete();
            return redirect()->route('scrapSale.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('scrapSale.create')->withErrors($e->getMessage());
        }
    }

    public function Approved(ScrapSale $scrapSale,$status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapSale) {
                $q->where([['name', 'SCRAP SALE'], ['department_id', $scrapSale->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapSale) {
                $q->where('approvable_id', $scrapSale->id)
                    ->where('approvable_type', ScrapSale::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapSale) {
                $q->where([['name', 'SCRAP SALE'], ['department_id', $scrapSale->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapSale) {
                $q->where('approvable_id', $scrapSale->id)
                    ->where('approvable_type', ScrapSale::class);
            })->orderBy('order_by', 'desc')->first();
//                $approvalData = $scrapSale->approval()->create($data);
            DB::commit();
//            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
            $materials = $scrapSale->scrapSaleDetail->where('nestedMaterial.material_status','!=','Scrap Material');
            $material_ids = $materials->pluck('material_id');
                $stock_history_data = StockHistory::query()
                ->whereIn('material_id', $material_ids)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->material_id => $item
                    ];
                });
                $materialGroups = $scrapSale->scrapSaleDetail->groupBy('material_id');
                $stock_data = array();
                foreach ($materialGroups as $key => $materialGroup) {
                    $totalQuantity = 0;
                    if (!empty($stock_history_data[$key])) {
                        $present_stock = $stock_history_data[$key]->present_stock - $materialGroup->first()->quantity;

                        $stock_data[] = [
                            'cost_center_id' => $scrapSale->cost_center_id,
                            'material_id' => $key,
                            'previous_stock' => $stock_history_data[$key]->present_stock,
                            'quantity' => $materialGroup->first()->quantity,
                            'present_stock' => $present_stock,
                            'average_cost' => $stock_history_data[$key]->average_cost,
                            'after_discount_po' => $stock_history_data[$key]->after_discount_po
                        ];
                    }
                }
                $scrapSale->stocks()->createMany($stock_data);

                //accounts portion start
                $transection['voucher_type'] = 'Journal';
                $transection['transaction_date'] = date('d-m-Y',strtotime(now()));
                $transection['user_id'] = auth()->user()->id;

                $materialArray = []; $totalAmount=0;

//                dd($scrapSale->scrapSaleDetail);
                $materialGroups = $materials->groupBy('nestedMaterial.account_id')
                ->map(function ($items, $key) use (&$materialArray, $scrapSale, &$wipArray, &$totalAmount){
                    foreach ($items as  $item){
                        $itemStock = StockHistory::where('stockable_id',$scrapSale->id)->where('stockable_type',ScrapSale::class)
                            ->where('material_id',$item->material_id)->latest()->first();

                        $amount = $itemStock->average_cost * $item->quantity;
                        $totalAmount += $amount;
                    }

                    $invAccountData = Account::where('id',$key)->first();
                    $invAccount = explode('- Inv', $invAccountData->account_name);
                    $wipAccount = Account::where('parent_account_id', 139)->where('account_name', 'like', "%$invAccount[0]%")->first();
                    $materialArray[] =[
                        'account_id' => $key,
                        'cr_amount' => $totalAmount,
                        'pourpose' => 'Scrap Sale',
                        'cost_center_id' => $scrapSale->cost_center_id,
                    ];

                    $wipArray[] =[
                        'account_id' => $wipAccount->id,
                        'dr_amount' => $totalAmount,
                        'pourpose' => 'Scrap Sale',
                        'cost_center_id' => $scrapSale->cost_center_id,
                    ];
                });

                $cashAccount  = Account::where('account_name', 'Cash in Hand')->first();
                $scrapAccount  = Account::where('account_name', 'Scrap Sale')->first();
                $cashAccountArray =[
                    'account_id' => $cashAccount->id,
                    'dr_amount' => $scrapSale->grand_total,
                    'pourpose' => 'Scrap Sale',
                    'cost_center_id' => $scrapSale->cost_center_id,
                ];

                $scrapArray =[
                    'account_id' => $scrapAccount->id,
                    'cr_amount'  => $scrapSale->grand_total,
                    'pourpose' => '',
                    'cost_center_id' => $scrapSale->cost_center_id,
                ];

//                dd($cashAccountArray,$supplierArray );

            $transectionData = $scrapSale->transaction()->create($transection);
            $transectionData->ledgerEntries()->createMany($materialArray);
            $transectionData->ledgerEntries()->createMany($wipArray);

            $transectionSupplier = $scrapSale->transaction()->create($transection);
            $transectionSupplier->ledgerEntries()->create($cashAccountArray);
            $transectionSupplier->ledgerEntries()->create($scrapArray);

//            }
            return redirect()->route('scrapSale.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }


    }
}
