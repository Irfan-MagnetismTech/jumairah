<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Http\Controllers\Controller;

use App\Country;
use App\Http\Requests\SupplierRequest;
use App\Procurement\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;

class SupplierController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:supplier-view|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','show']]);
        $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('procurement.suppliers.index', compact('suppliers'));

        return view('procurement.suppliers.index', compact('suppliers','sectionId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Account::where('balance_and_income_line_id',34)
            ->where('parent_account_id',null)->pluck('account_name','id');

        $countries = Country::orderBy('name')->pluck('name');
        $formType ='create';
        return view('procurement.suppliers.create', compact( 'categories','countries','formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        // $request->dd();
        try{
            $data = $request->only('type','country','name','address', 'contact_person_name', 'contact','email');
            $account = Account::where('id', $request->parent_account_id)->first(['balance_and_income_line_id']);

            $accountData = $request->only( 'account_code', 'parent_account_id');
            $accountData['account_name']= $request->name;
            $accountData['account_type']= '2';
            $accountData['balance_and_income_line_id']= $account->balance_and_income_line_id;
            DB::transaction(function()use($data, $accountData){
                $supplierId = Supplier::create($data);
                $supplierId->account()->create($accountData);
            });

            return redirect()->route('suppliers.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $categories = Account::where('balance_and_income_line_id',34)->where('parent_account_id',null)->pluck('account_name','id');
        $countries = Country::orderBy('name')->pluck('name');
        $formType ='edit';
        return view('procurement.suppliers.create', compact( 'categories','countries','supplier','formType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        // $request->dd();
        try{
            $data = $request->only('type','country','name','address','contact', 'contact_person_name', 'email');
            $account = Account::where('id', $request->parent_account_id)->first(['balance_and_income_line_id']);

            $accountData = $request->only('account_code', 'account_code', 'parent_account_id');
            $accountData['account_name']= $request->name;
            $accountData['account_type']= '2';
            $accountData['balance_and_income_line_id']= $account->balance_and_income_line_id;
            DB::transaction(function()use($data, $accountData, $supplier){
                $supplier->update($data);
                $supplier->account()->updateOrCreate(
                    ['accountable_type'=>Supplier::class,'accountable_id'=>$supplier->id],
                    $accountData
                );
            });
            return redirect()->route('suppliers.index')->with('message', 'Data has been Updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try{
            if($supplier->account->ledgers()->exists()){
                return redirect()->route('suppliers.index')->with('error', 'Please Delete Transaction First');
            }else{
                DB::transaction(function () use($supplier) {
                    $supplier->delete();
                    $supplier->account()->delete();
                });
                return redirect()->route('suppliers.index')->with('message', 'Data has been deleted successfully');
            }
        }catch(QueryException $e){
            return redirect()->route('suppliers.index')->withErrors($e->getMessage());
        }
    }
}
