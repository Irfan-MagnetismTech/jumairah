<?php

namespace App\Http\Controllers\Boq\Departments\Civil\Cost;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoqCivilLabourBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project)
    {
        try {
            $boq_floors = BoqCivilBudget::where('project_id', $project->id)
                ->where('budget_type', 'labour')->with('boqCivilCalcProjectFloor')->groupBy('boq_floor_id')->get();

            $boq_works = BoqCivilBudget::where('project_id', $project->id)
                ->where('budget_type', 'labour')->with('boqWork')->groupBy('boq_work_id')->get();

            if ($request->work_id != '' && $request->boq_floor_id != '')
            {
                $labour_statements = BoqCivilBudget::where('project_id', $project->id)
                    ->where('budget_type', 'labour')
                    ->where('boq_work_id', $request->work_id)
                    ->where('boq_floor_id', $request->boq_floor_id)
                    ->get();
            }
            else
            {
                $labour_statements = [];
            }

            return view('boq.departments.civil.costs.labour.labour-cost-floorwise', compact('project', 'labour_statements',
                'boq_floors', 'boq_works'));

        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
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
            DB::transaction(function () use ($request, $project)
            {
                $boq_civil_budget = BoqCivilBudget::where('id', $request->id)->first();

                $boq_civil_budget->update([
                    'rate'         => $request->rate,
                    'total_amount' => $boq_civil_budget->quantity * $request->rate,
                ]);
            });

            return redirect()->back()->withMessage('Labour cost updated successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
