<?php

namespace App\Http\Controllers\Bd;

use Illuminate\Http\Request;
use App\Procurement\NestedMaterial;
use App\Bd\BdFeasibilitySiteExpense;
use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bd\BdFeasibilitySiteExpenseRequest;
use Illuminate\Database\QueryException;

class BdFeasibilitySiteExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($BdLeadGeneration_id) 
    {
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        $BdLeadGenerations = BdFeasibilitySiteExpense::where('bd_leadgeneration_id',$BdLeadGeneration_id)->latest()->get(); 
        return view('bd.feasibility.location.site-expense.index', compact('BdLeadGenerations', 'BdLeadGeneration_id', 'bd_lead_location_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($BdLeadGeneration_id)
    {
        $formType = 'create';
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        return view('bd.feasibility.location.site-expense.create', compact('formType', 'BdLeadGeneration_id', 'bd_lead_location_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasibilitySiteExpenseRequest $request, $BdLeadGeneration_id)
    {
        try{
            $data = $request->all();
            $data['bd_leadgeneration_id'] = $BdLeadGeneration_id;
            BdFeasibilitySiteExpense::create($data);
            return redirect()->route('feasibility.location.site-expense.index',$BdLeadGeneration_id)->with('message', 'Site Expenses has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.site-expense.create')->withInput()->withErrors($e->getMessage());
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
    public function edit($BdLeadGeneration_id, $site_expense_id)
    {
        $formType = 'edit';
        $bd_lead_location_name = BdLeadGeneration::where('id', $BdLeadGeneration_id)->get();
        $site_expense = BdFeasibilitySiteExpense::findOrFail($site_expense_id);
        return view('bd.feasibility.location.site-expense.create', compact('formType', 'BdLeadGeneration_id', 'site_expense_id', 'site_expense', 'bd_lead_location_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFeasibilitySiteExpenseRequest $request, $BdLeadGeneration_id, $site_expense_id)
    {
        try{
            $data = $request->all();
            $bd_site_expense = BdFeasibilitySiteExpense::findOrFail($site_expense_id);
            $bd_site_expense->update($data);
            return redirect()->route('feasibility.location.site-expense.index',$BdLeadGeneration_id)->with('message', 'Site Expenses has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.site-expense.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($BdLeadGeneration_id, $site_expense_id)
    {
        try{
            $site_expense = BdFeasibilitySiteExpense::findOrFail($site_expense_id);
            $site_expense->delete();
            return redirect()->route('feasibility.location.site-expense.index',$BdLeadGeneration_id)->with('message', 'Site Expenses has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('feasibility.location.site-expense.create')->withErrors($e->getMessage());
        }
    }

    

}
