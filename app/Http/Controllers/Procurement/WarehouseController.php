<?php

namespace App\Http\Controllers\Procurement;

use App\User;

use App\Employee;
use Illuminate\Http\Request;
use App\Procurement\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Database\QueryException;

class WarehouseController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:warehouse-list|warehouse-create|warehouse-edit|warehouse-delete', ['only' => ['index','show']]);
        $this->middleware('permission:warehouse-create', ['only' => ['create','store']]);
        $this->middleware('permission:warehouse-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:warehouse-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $warehouses = Warehouse::with('users')->latest()->paginate();
        
        return view('procurement.warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $warehouses = Warehouse::latest()->paginate();
        $employees = User::orderBy('name')->pluck('name','id');
        return view('procurement.warehouses.create', compact('warehouses', 'formType', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)
    {
        
        try{
            $data = $request->only('type','name','location','contact_person_id','number');
            $data['prepared_by'] = auth()->user()->id;
            $warehouseDetail = $request->only('total_value', 'per_mounth_rent','adjusted_amount', 'advance', 'duration', 'owner_name', 'owner_contact', 'owner_address');
            DB::transaction(function() use($data, $warehouseDetail){
                $warehouse = Warehouse::create($data);
                $warehouse->WarehouseDetail()->create($warehouseDetail);
            });
            return redirect()->route('warehouses.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('warehouses.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        $formType = "edit";
        $warehouses = Warehouse::latest()->paginate();
        $employees = User::orderBy('name')->pluck('name','id');
//        dd($employees);
        return view('procurement.warehouses.create', compact('warehouse', 'warehouses', 'formType', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        try{
            $data = $request->all();
            $warehouse->update($data);
            return redirect()->route('warehouses.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('warehouses.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        try{
            $warehouse->delete();
            return redirect()->route('warehouses.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('warehouses.index')->withErrors($e->getMessage());
        }
    }

    public function Approved(Warehouse $warehouse,$status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($warehouse) {
                $q->where([['name', 'WAREHOUSE'], ['department_id', $warehouse->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($warehouse) {
                $q->where('approvable_id', $warehouse->id)
                    ->where('approvable_type', Warehouse::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($warehouse) {
                $q->where([['name', 'WAREHOUSE'], ['department_id', $warehouse->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($warehouse) {
                $q->where('approvable_id', $warehouse->id)
                    ->where('approvable_type', Warehouse::class);
            })->orderBy('order_by', 'desc')->first();
                $approvalData = $warehouse->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
               
            }
            return redirect()->route('warehouses.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        

    }
}
