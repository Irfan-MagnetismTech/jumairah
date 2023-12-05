<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Configurations;

use App\Boq\Departments\Eme\EmeBudgetHead;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\EmeBudgetHeadRequest;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmeBudgetHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $formType = "create";
        $budgetHeadData = EmeBudgetHead::latest()->get();
        return view('boq.departments.electrical.configurations.budget-head.create', compact('project', 'formType', 'budgetHeadData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmeBudgetHeadRequest $request, Project $project)
    {
        try{
            $budgetHeadData = $request->only('name');
            $budgetHeadData['user_id'] = auth()->user()->id;

            DB::transaction(function()use($budgetHeadData){
                EmeBudgetHead::create($budgetHeadData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.eme-budget-head.create',$project)->with('message', 'Data has been inserted successfully');
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
    public function edit(Project $project, EmeBudgetHead $eme_budget_head)
    {
        $formType = "edit";
        $budgetHead = EmeBudgetHead::where('id', $eme_budget_head->id)->first();
        $budgetHeadData = EmeBudgetHead::latest()->get();
        return view('boq.departments.electrical.configurations.budget-head.create', compact('project', 'formType', 'budgetHead', 'budgetHeadData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmeBudgetHeadRequest $request, Project $project, EmeBudgetHead $eme_budget_head)
    {
        try{
            $budgetHeadData = $request->only('name');
            $budgetHeadData['user_id'] = auth()->user()->id;
            $budgetHead = EmeBudgetHead::where('id', $eme_budget_head->id)->first();

            DB::transaction(function()use($budgetHeadData, $budgetHead){
                $budgetHead->update($budgetHeadData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.eme-budget-head.create',$project)->with('message', 'Data has been inserted successfully');
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
    public function destroy(Project $project, EmeBudgetHead $eme_budget_head)
    {
        try{
            $budgetHead =  EmeBudgetHead::findOrFail($eme_budget_head->id);
            $budgetHead->delete();
            return redirect()->route('boq.project.departments.electrical.configurations.eme-budget-head.create',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('boq.project.departments.electrical.configurations.eme-budget-head.create',$project)->withErrors($e->getMessage());
        }
    }
}
