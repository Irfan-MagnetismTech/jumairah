<?php

namespace App\Http\Controllers\Procurement;

use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\MovementRequest;
use App\Procurement\Materialmovement;
use App\Procurement\MovementRequisition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class MaterialmovementController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:materialmovement-list|materialmovement-create|materialmovement-edit|materialmovement-delete', ['only' => ['index','show', 'getmaterialmaterialmovementsPdf', 'movmentOutApproval']]);
        $this->middleware('permission:materialmovement-create', ['only' => ['create','store']]);
        $this->middleware('permission:materialmovement-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:materialmovement-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $movements = Materialmovement::with('movementdetails')->latest()->get();
        return view('procurement.materialmovements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $requisitions =[];
        return view('procurement.materialmovements.create', compact('requisitions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementRequest $request)
    {
        try{
            $movementData = $request->only('transfer_date', 'mto_no');
            $movementData['entry_by'] = auth()->id();

            $movementDetailData = array();
            foreach($request->material_id as  $key => $data){
                $movementDetailData[] = [
                    'movement_requision_id' =>$request->movement_requisition_id[$key],
                    'gate_pass'         =>$request->gate_pass[$key],
                    'material_id'       =>$request->material_id[$key],
                    'quantity'          =>$request->mtrf_quantity[$key],
                    'remarks'           =>$request->remarks[$key],
                    'fixed_asset_id'    =>$request->tag[$key],
                ];
            }

            DB::transaction(function()use($movementData, $movementDetailData){
                $movement = Materialmovement::create($movementData);
                $movement->movementdetails()->createMany($movementDetailData);
            });

            return redirect()->route('materialmovements.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materialmovement  $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Materialmovement $movement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materialmovement  $movement
     * @return \Illuminate\Http\Response
     */
    public function edit(Materialmovement $materialmovement)
    {
        $requisitions = MovementRequisition::pluck('mtrf_no', 'id');
        return view('procurement.materialmovements.create', compact( 'materialmovement','requisitions' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materialmovement  $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materialmovement $materialmovement)
    {
        try{
            $movementData = $request->only('transfer_date', 'mto_no');
            $movementData['entry_by'] = auth()->id();
            //dd($movementData);

            $movementDetailData = array();
            foreach($request->material_id as  $key => $data){
                $movementDetailData[] = [
                    'movement_requision_id' =>$request->movement_requisition_id[$key],
                    'gate_pass'         =>$request->gate_pass[$key],
                    'material_id'       =>$request->material_id[$key],
                    'quantity'          =>$request->mtrf_quantity[$key],
                    'remarks'           =>$request->remarks[$key],
                    'fixed_asset_id'    =>$request->tag[$key],
                ];
            }

            DB::transaction(function()use($materialmovement, $movementData, $movementDetailData){
                $materialmovement->update($movementData);
                $materialmovement->movementdetails()->delete();
                $materialmovement->movementdetails()->createMany($movementDetailData);
            });

            return redirect()->route('materialmovements.index')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materialmovement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materialmovement $materialmovement)
    {
        try{
            $materialmovement->delete();
            return redirect()->route('materialmovements.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('materialmovements.index')->withErrors($e->getMessage());
        }
    }

    /**
     * @param Cs $comparative_statement
     */
    public function getmaterialmovementsPdf(Materialmovement $material_movement)
    {
        $movements = $material_movement->movementdetails()->get();

        return \PDF::loadview('procurement.materialmovements.pdf', compact(
            'material_movement',
            'movements'
            ))
            ->setPaper('a4', 'landscape')
            ->stream('Material-movement-report.pdf');
    }

    public function movmentOutApproval(Materialmovement $materialmovement, $status){
        // dd($materialmovement);
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Movement Out');
            })->whereDoesntHave('approvals',function ($q) use($materialmovement){
                $q->where('approvable_id',$materialmovement->id)->where('approvable_type',Materialmovement::class);
            })->orderBy('order_by','asc')->first();

            // dd($movement_requisition);
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            $materialmovement->approval()->create($data);
            DB::transaction(function () use ($data, $materialmovement){
                //  Stock history calculation start
                // foreach($materialmovement->movementdetails as $details){
                //     $stock_history_data = StockHistory::where('cost_center_id', $details->movementRequisition->from_costcenter_id)
                //     ->where('material_id', $details->material_id)->latest('id')
                //     ->first();
                //         $stock_data = [
                //             'cost_center_id' => $details->movementRequisition->from_costcenter_id,
                //             'material_id' => $details->material_id,
                //             'previous_stock' => $stock_history_data->present_stock,
                //             'quantity' => $details->quantity,
                //             'present_stock' => $stock_history_data->present_stock - $details->quantity,
                //             'average_cost' => $stock_history_data->average_cost,
                //             'after_discount_po' => $stock_history_data->after_discount_po,
                //         ];
                //         // dump($stock_history_data);
                //         $materialmovement->stocks()->create($stock_data);
                //     ////  Stock history calculation end
                // }
                // die();
            });

            return redirect()->route('materialmovements.index')->with('message', "MTO No $materialmovement->mto_no approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
