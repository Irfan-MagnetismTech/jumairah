<?php

namespace App\Http\Controllers\Billing;

use Illuminate\Http\Request;
use App\Billing\BillingTitle;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class BillingTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = BillingTitle::latest()->paginate();
        return view('billing.bill-title.create', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = BillingTitle::latest()->paginate();
        return view('billing.bill-title.create', compact('departments'));
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
            $data = $request->all();
            BillingTitle::create($data);
            return redirect()->route('bill-title.create')->with('message', 'Data has been inserted successfully');
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
    public function edit(BillingTitle $bill_title)
    {
        $departments = BillingTitle::latest()->paginate();
        return view('billing.bill-title.create', compact('bill_title', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillingTitle $bill_title)
    {
        try{
            $data = $request->all();
            $bill_title->update($data);
            return redirect()->route('bill-title.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('bill-title.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingTitle $bill_title)
    { 
        try{  
        $bill_title->delete();
        return redirect()->route('bill-title.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bill-title.create')->withErrors($e->getMessage());
        }//
    }
}
