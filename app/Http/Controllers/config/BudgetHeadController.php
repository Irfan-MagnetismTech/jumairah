<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Config\BudgetHead;
use Illuminate\Database\QueryException;
use App\Http\Requests\config\BudgetHeadRequest;

class BudgetHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formType = "create";
        $budget_head_data = BudgetHead::latest()->get();
        return view('config.budget_head.create', compact('budget_head_data', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $budget_head_data = BudgetHead::latest()->get();
        return view('config.budget_head.create', compact('budget_head_data', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetHeadRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:budget_heads',
        ]);

        try{
            $data = $request->all();
            BudgetHead::create($data);
            return redirect()->route('budget-head.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('budget-head.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(BudgetHead $budget_head)
    {
        $formType = "edit";
        $budget_head_data = BudgetHead::latest()->get();
        return view('config.budget_head.create', compact('budget_head', 'budget_head_data', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetHeadRequest $request, BudgetHead $budget_head)
    {
        $validated = $request->validate([
            'name' => 'required|unique:budget_heads',
        ]);

        try{
            $data = $request->all();
            $budget_head->update($data);
            return redirect()->route('budget-head.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('budget-head.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetHead $budget_head)
    {
        try{
            $budget_head->delete();
            return redirect()->route('budget-head.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('budget-head.create')->withErrors($e->getMessage());
        }
    }
}
