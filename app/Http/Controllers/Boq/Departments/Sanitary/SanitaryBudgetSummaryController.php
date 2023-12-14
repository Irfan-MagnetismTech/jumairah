<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\SanitaryBudgetSummary;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Boq\BoqSanitaryBudgetSummaryRequest;

class SanitaryBudgetSummaryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Project $project)
    {
        $allData = SanitaryBudgetSummary::latest()->where('project_id', $project->id)->get();
        return view('boq.departments.sanitary.budget-summaries.index', compact('allData','project'));
    }

    public function create()
    {
        $formType = 'create';
        $projectData = Project::where('id', session()->get('project_id'))->first();
        return view('boq.departments.sanitary.budget-summaries.create', compact('projectData','formType'));
    }

    public function store(BoqSanitaryBudgetSummaryRequest $request)
    {
        try{
            $project = session()->get('project_id');
            $data = $request->all();
            $data['project_id'] = $project;
            $data['user_id'] = auth()->user()->id;
            SanitaryBudgetSummary::create($data);
            return redirect()->route('boq.project.departments.sanitary.sanitary-budget-summaries.index', ['project' => $project])
                ->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(SanitaryBudgetSummary $sanitaryBudgetSummary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanitaryBudgetSummary  $sanitaryBudgetSummary
     * @return \Illuminate\Http\Response
     */
    public function edit($project,SanitaryBudgetSummary $sanitaryBudgetSummary)
    {
        //
        $formType = 'create';
        $projectData = Project::where('id', session()->get('project_id'))->first();
        return view('boq.departments.sanitary.budget-summaries.create', compact('projectData','sanitaryBudgetSummary','formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanitaryBudgetSummary  $sanitaryBudgetSummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$project,SanitaryBudgetSummary $sanitaryBudgetSummary)
    {
        //
        try{
            $data = $request->all();
            $data['project_id'] = $project;
            $data['user_id'] = auth()->user()->id;
            DB::transaction(function()use($sanitaryBudgetSummary,$data){
                $sanitaryBudgetSummary->update($data);
            });
            return redirect()->route('boq.project.departments.sanitary.sanitary-budget-summaries.index', ['project' => $project])
                ->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanitaryBudgetSummary  $sanitaryBudgetSummary
     * @return \Illuminate\Http\Response
     */
    public function destroy($project,SanitaryBudgetSummary $sanitaryBudgetSummary)
    {
        //
        try {
            $sanitaryBudgetSummary->delete();
            return redirect()->route('boq.project.departments.sanitary.sanitary-budget-summaries.index', ['project' => $project])->with('message', 'Data has been Deleted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
