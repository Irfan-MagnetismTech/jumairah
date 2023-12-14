<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovementInRequest;
use App\Http\Requests\UpdateMovementInRequest;
use App\Procurement\Materialmovement;
use App\Procurement\Materialmovementdetail;
use App\Procurement\MovementIn;
use App\Procurement\StockHistory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovementInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:movementIn-view|movementIn-create|movementIn-edit|movementIn-delete', ['only' => ['index','show', 'getmaterialmovementsPdf', 'movmentOutApproval']]);
        $this->middleware('permission:movementIn-create', ['only' => ['create','store']]);
        $this->middleware('permission:movementIn-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:movementIn-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movements = MovementIn::with('movementInDetails')->latest()->get();
        return view('procurement.movementIns.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('procurement.movementIns.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\StoreMovementInRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovementInRequest $request)
    {
        try{
            $movementData = $request->only('receive_date', 'materialmovement_id','mti_no');
            $movementData['entry_by'] = auth()->id();

            $movementDetailData = array();
            foreach($request->material_id as  $key => $data){
                $movementDetailData[] = [
                    'movement_requisition_id'  =>$request->movement_requisition_id[$key],
                    'material_id'           =>$request->material_id[$key],
                    'mti_quantity'              =>$request->mti_quantity[$key],
                    'damage_quantity'       =>$request->damage_quantity[$key],
                    'remarks'               =>$request->remarks[$key]
                ];
            }

            // dd($request->all(), $movementDetailData);

            DB::transaction(function()use($movementData, $movementDetailData){
                $movement = MovementIn::create($movementData);
                $movement->movementInDetails()->createMany($movementDetailData);
            });

            return redirect()->route('movement-ins.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MovementIn  $movementIn
     * @return \Illuminate\Http\Response
     */
    public function show(MovementIn $movementIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MovementIn  $movementIn
     * @return \Illuminate\Http\Response
     */
    public function edit(MovementIn $movementIn)
    {
        $requisitions = Materialmovementdetail::with('movementRequisition')->where('materialmovement_id', $movementIn->materialmovement_id)
                        ->get()->pluck('movementRequisition.mtrf_no', 'movement_requision_id');
        return view('procurement.movementIns.create', compact( 'movementIn','requisitions' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovementInRequest  $request
     * @param  \App\MovementIn  $movementIn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovementInRequest $request, MovementIn $movementIn)
    {
        try{
            $movementData = $request->only('receive_date', 'materialmovement_id','mti_no');
            $movementData['entry_by'] = auth()->id();

            $movementDetailData = array();
            foreach($request->material_id as  $key => $data){
                $movementDetailData[] = [
                    'movement_requisition_id'  =>$request->movement_requisition_id[$key],
                    'material_id'           =>$request->material_id[$key],
                    'mti_quantity'              =>$request->mti_quantity[$key],
                    'damage_quantity'       =>$request->damage_quantity[$key],
                    'remarks'               =>$request->remarks[$key]
                ];
            }

            DB::transaction(function()use($movementIn, $movementData, $movementDetailData){
                $movementIn->update($movementData);
                $movementIn->movementInDetails()->delete();
                $movementIn->movementInDetails()->createMany($movementDetailData);
            });

            return redirect()->route('movement-ins.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MovementIn  $movementIn
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovementIn $movementIn)
    {
        try{
            $movementIn->delete();
            return redirect()->route('movement-ins.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function movmentInApproval(MovementIn $movementIn, $status){
        try{

            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use($movementIn){
                $q->where([['name','Movement In'],['department_id',$movementIn->appliedBy->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($movementIn){
                $q->where('approvable_id',$movementIn->id)->where('approvable_type',Materialmovement::class);
            })->orderBy('order_by','asc')->first();

            // dd($movement_requisition);
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            DB::transaction(function() use($movementIn){

                foreach($movementIn->movementInDetails as $details){
                    $stock_history_out = StockHistory::where('cost_center_id', $details->movementRequisition->from_costcenter_id)
                    ->where('material_id', $details->material_id)->latest('id')
                    ->first();
                        $stock_data_out = [
                            'cost_center_id' => $details->movementRequisition->from_costcenter_id,
                            'material_id' => $details->material_id,
                            'previous_stock' => $stock_history_out->present_stock,
                            'quantity' => $details->mti_quantity,
                            'present_stock' => $stock_history_out->present_stock - $details->mti_quantity,
                            'average_cost' => $stock_history_out->average_cost,
                            'after_discount_po' => $stock_history_out->after_discount_po,
                        ];
                        $stock_history_In = StockHistory::where('cost_center_id', $details->movementRequisition->to_costcenter_id)
                        ->where('material_id', $details->material_id)->latest('id')->first();
                        if(!empty($stock_history_In)){
                            $stock_data_In = [
                                'cost_center_id'    => $details->movementRequisition->to_costcenter_id,
                                'material_id'       => $details->material_id,
                                'previous_stock'    =>  $stock_history_In->present_stock,
                                'quantity'          =>  $details->mti_quantity,
                                'present_stock'     =>  $stock_history_In->present_stock + $details->mti_quantity,
                                'average_cost'      =>  $stock_history_out->average_cost,
                                'after_discount_po' =>  $stock_history_out->after_discount_po,
                            ];
                        }else{
                            $stock_data_In = [
                                'cost_center_id'    => $details->movementRequisition->to_costcenter_id,
                                'material_id'       => $details->material_id,
                                'previous_stock'    => 0,
                                'quantity'          => $details->mti_quantity,
                                'present_stock'     => $details->mti_quantity,
                                'average_cost'      => $stock_history_out->average_cost,
                                'after_discount_po' => $stock_history_out->after_discount_po ,
                            ];
                        }
                        // dump($stock_data_out, $stock_data_In);
                        $movementIn->stocks()->create($stock_data_out);
                        $movementIn->stocks()->create($stock_data_In);
                    ////  Stock history calculation end
                }
            ////  Account calculation start
                $dateNow = date('d-m-Y', strtotime(now()));
                $transection['voucher_type'] = 'Journal';
                $transection['transaction_date'] = "$dateNow";
                $transection['user_id'] = auth()->user()->id;

                $fromCostCenter = $movementIn->movementInDetails->pluck('movementRequisition.from_costcenter_id','movementRequisition.from_costcenter_id')->toArray();
                $toCostCenter = $movementIn->movementInDetails->pluck('movementRequisition.to_costcenter_id','movementRequisition.to_costcenter_id')->toArray();
                $movementStockOuts = $movementIn->stocks()->where('cost_center_id',$fromCostCenter)
                                    ->get()->groupBy('nestedMaterial.account_id');
                $movementStockIns = $movementIn->stocks()->where('cost_center_id',$toCostCenter)
                                    ->get()->groupBy('nestedMaterial.account_id');
                // dump($movementStockOuts->toArray());
                $stockCrData =[]; $stockDrData =[];
                foreach ($movementStockOuts as $key => $movementOutMaterials){
                    $outAmountTotal = 0;
                    foreach ($movementOutMaterials as $movementOutMaterial){
                        $outAmount = $movementOutMaterial->quantity * $movementOutMaterial->average_cost;
                        $outAmountTotal += $outAmount;
                    }

                    $invAccountData = Account::where('id',$key)->first();
                    $invAccount = explode('- Inv', $invAccountData->account_name);
                    $wipAccount = Account::where('parent_account_id', 139)->where('account_name', 'like', "%$invAccount[0]%")->first();
                    $stockCrData[] = [
                        'account_id' => $wipAccount->id,
                        'cr_amount' => $outAmountTotal,
                        'pourpose' => 'Movement Out',
                        'cost_center_id' => $movementOutMaterials->first()->cost_center_id,
                    ];
                }
                foreach ($movementStockIns as $inkey => $movementStockIn){
                    $inAmountTotal = 0;
                    foreach ($movementStockIn as $movementInMaterial){
                        $inAmount = $movementInMaterial->quantity * $movementInMaterial->average_cost;
                        $inAmountTotal += $inAmount;
                    }
                    // dump($outAmountTotal);
                    $invAccountData = Account::where('id',$inkey)->first();
                    $invAccount = explode('- Inv', $invAccountData->account_name);
                    $wipAccount = Account::where('parent_account_id', 139)->where('account_name', 'like', "%$invAccount[0]%")->first();
                    // dd($wipAccount);
                    $stockDrData[] = [
                        'account_id' => $wipAccount->id,
                        'dr_amount' => $inAmountTotal,
                        'pourpose' => 'Movement In',
                        'cost_center_id' => $movementStockIn->first()->cost_center_id,
                    ];
                }
                // dump($transection, $stockCrData, $stockDrData);
                $transectionData = $movementIn->transaction()->create($transection);
                $transectionData->ledgerEntries()->createMany($stockDrData);
                $transectionData->ledgerEntries()->createMany($stockCrData);
                // dump($fromCostCenter, $toCostCenter);
            });

            $movementIn->approval()->create($data);

            return redirect()->route('movement-ins.index')->with('message', 'Approved  successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }



    }
}
