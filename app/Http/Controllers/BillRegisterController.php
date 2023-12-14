<?php

namespace App\Http\Controllers;

use App\BillRegister;
use App\Department;
use App\Employee;
use App\Procurement\Supplier;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Requests\BillRegister\CreateRequest;
use App\Http\Requests\BillRegister\UpdateRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\BillRegister\BillRegisterRequest;

class BillRegisterController extends Controller
{

    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:bill-register-view|bill-register-create|bill-register-edit|bill-register-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bill-register-create', ['only' => ['create','store']]);
        $this->middleware('permission:bill-register-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bill-register-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill_registers = BillRegister::latest('id')->get();
        return view('bill-register.index',compact('bill_registers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
       $suppliers = Supplier::latest()->pluck('name','id');
       $departments = Department::latest()->pluck('name','id');
       return view('bill-register.create',compact('suppliers', 'departments','formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillRegisterRequest $request)
    {
        try{
            $BillRegister = array();
            foreach($request->supplier_id as  $key => $data){
                if($request->bill_no[$key]){
                    $bill_no = "B_".$request->bill_no[$key];
                }else{
                    $bill_no = "OB_".$request->serial_no[$key];
                }
                $BillRegister[] = [
                    'serial_no'     =>  $request->serial_no[$key],
                    'bill_no'       =>  $bill_no,
                    'supplier_id'   =>  $request->supplier_id[$key],
                    'department_id'   =>  $request->department_id[$key],
                    'amount'        =>  $request->amount[$key],
                    'created_at'    => now()
                ];
            }
            DB::transaction(function () use ($BillRegister) {
                BillRegister::insert($BillRegister);
            });
            return redirect()->route('bill-register.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(BillRegister $billRegister)
    {
        $formType = 'edit';
        $suppliers = Supplier::latest()->pluck('name','id');
        $departments = Department::latest()->pluck('name','id');
        $employees = Employee::orderBy('fname')->where('department_id', $billRegister->department_id)->get(['id','fname','lname'])->pluck('fullName', 'id');
        return view('bill-register.create',compact('suppliers', 'departments','formType','billRegister','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillRegisterRequest $request, BillRegister $billRegister)
    {
        try{
             foreach($request->supplier_id as  $key => $data){
                 $BillRegister = [
                     'serial_no'     =>  $request->serial_no[$key],
                     'bill_no'       =>  $request->bill_no[$key],
                     'supplier_id'   =>  $request->supplier_id[$key],
                     'department_id'   =>  $request->department_id[$key],
                     'amount'        =>  $request->amount[$key]
                 ];
             }
             DB::transaction(function () use ($BillRegister,$billRegister) {
                $billRegister->update($BillRegister);
             });
             return redirect()->route('bill-register.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(BillRegister $billRegister)
    {
        try{
            $billRegister->delete();
            return redirect()->route('bill-register.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bill-register.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Accept specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function bill_accept(BillRegister $bill_register_id)
    {
        $author = auth()->user()->name;
        $bill_no = $bill_register_id->bill_no;
        try{
            $data =[
                'status' => 1,
                'accepted_date' => date('Y-m-d h:i:s A'),
                'user_id' => auth()->id(),
                'department_id' => auth()->user()->department->id
            ];
            $bill_register_id->update($data);
            return redirect()->route('bill-register.index')->with('message', 'Bill No '.$bill_no.' has been accepted by '.$author);
        }catch(QueryException $e){
            return redirect()->route('bill-register.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Approve specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function bill_delivered(BillRegister $bill_register_id)
    {
        $author = auth()->user()->name;
        $bill_no = $bill_register_id->bill_no;
        try{
            $data =[
                'deliver_status' => 1, 
                'delivery_date' => date('Y-m-d h:i:s A'),
            ];
            $bill_register_id->update($data);
            return redirect()->route('bill-register.index')->with('message', 'Bill No '.$bill_no.' has been accepted by '.$author);
        }catch(QueryException $e){
            return redirect()->route('bill-register.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Accept specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function bill_register_approve(BillRegister $bill_register_id)
    {
        $author = auth()->user()->name;
        $bill_no = $bill_register_id->bill_no;
        try{
            $data =[
                'approval_status' => 1,
            ];
            $bill_register_id->update($data);
            return redirect()->route('bill-register.index')->with('message', 'Bill No '.$bill_no.' has been approved by '.$author);
        }catch(QueryException $e){
            return redirect()->route('bill-register.index')->withErrors($e->getMessage());
        }
    }
}
