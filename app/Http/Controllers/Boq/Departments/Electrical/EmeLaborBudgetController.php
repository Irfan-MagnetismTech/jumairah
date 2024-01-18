<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Eme\BoqEmeRate;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\EmeLaborHead;
use App\Boq\Departments\Eme\EmeLaborBudget;

class EmeLaborBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $emeLaborBudget = EmeLaborBudget::all();
        return view('boq.departments.electrical.labor_budget.index', compact('project', 'emeLaborBudget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $formType = 'create';
        $parentWorks = BoqEmeRate::groupBy('parent_id_second')->having('type', 1)->get();
        return view('boq.departments.electrical.labor_budget.create', compact('project', 'formType', 'parentWorks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        try {
            $emeLaborBudget = array();
            foreach ($request->boq_eme_rate_id as  $key => $data) {
                $emeLaborBudget[] = [
                    'project_id'            =>  $project->id,
                    'boq_eme_rate_id'       =>  $request->boq_eme_rate_id[$key],
                    'labor_rate'            =>  $request->labor_rate[$key],
                    'quantity'              =>  $request->quantity[$key],
                    'total_labor_amount'    =>  $request->total_labor_amount[$key],
                    'remarks'               =>  $request->remarks[$key],
                    'applied_by'            =>  auth()->id(),
                    'created_at'            =>  now()
                ];
            }

            DB::transaction(function () use ($emeLaborBudget) {
                EmeLaborBudget::insert($emeLaborBudget);
            });

            return redirect()->route('boq.project.departments.electrical.eme-labor-budgets.index', $project)->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
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
    public function edit(Project $project, $EmeLaborBudgetId)
    {
        $formType = 'edit';
        $EmeLaborBudget =  EmeLaborBudget::findOrFail($EmeLaborBudgetId);
        $parentWorks = BoqEmeRate::groupBy('parent_id_second')->having('type', 1)->get();
        return view('boq.departments.electrical.labor_budget.create', compact('project', 'parentWorks', 'EmeLaborBudget', 'formType', 'EmeLaborBudgetId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Project $project, $EmeLaborBudgetId)
    {
        try {
            $EmeLaborBudget =  EmeLaborBudget::findOrFail($EmeLaborBudgetId);
            $data = array();
            foreach ($request->boq_eme_rate_id as  $key => $data) {
                $data = [
                    'project_id'            =>  $project->id,
                    'boq_eme_rate_id'       =>  $request->boq_eme_rate_id[$key],
                    'labor_rate'            =>  $request->labor_rate[$key],
                    'quantity'              =>  $request->quantity[$key],
                    'total_labor_amount'    =>  $request->total_labor_amount[$key],
                    'remarks'               =>  $request->remarks[$key],
                    'applied_by'            =>  auth()->id(),
                    'created_at'            =>  now()
                ];
            }

            DB::transaction(function () use ($data, $EmeLaborBudget) {
                $EmeLaborBudget->update($data);
            });

            return redirect()->route('boq.project.departments.electrical.eme-labor-budgets.index', $project)->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $EmeLaborBudgetId)
    {
        try {
            DB::beginTransaction();
            $EmeLaborBudget =  EmeLaborBudget::findOrFail($EmeLaborBudgetId);
            $EmeLaborBudget->delete();
            DB::commit();
            return redirect()->route('boq.project.departments.electrical.eme-labor-budgets.index', $project)->with('message', 'Data has been Deleted successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
