<?php

namespace App\Http\Controllers\Boq\Departments\Civil;

use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class BoqCivilHomeController extends Controller
{

    public function __invoke(Request $request, Project $project)
    {
        try {
            $total_area = $project->boqFloorProjects()->sum('area');

            if ((int) $total_area === 0)
            {
                return redirect()->route('boq.project.configurations.areas.index', ['project' => $project->id])
                    ->withError('Please add area for project');
            }

            $all_cost_summary = $project->boqCivilBudgets()
                ->selectRaw("*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'other' THEN total_amount ELSE 0 END) AS other_total_cost")
                ->get();
            //dd($all_cost_summary);

            // other related costs sum
            $other_related_costs = $project->boqCivilBudgets()
                ->where('budget_type', 'other')
                ->sum('total_amount');


            $total_cost = $all_cost_summary->sum(function ($sheet)
            {
                return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount;
            });

            $total_cost += $other_related_costs;

            $all_cost_summary = $all_cost_summary->first();

            //price escalation get group by escalation_no and budget_type and sum of amount_after_revised from boq_civil_revised_sheet table
            $price_escalations = $project->boqRevisedBudgets()
                ->where('escalation_no', '!=', 0)
                ->where('budget_for', 'civil')
                ->selectRaw("amount_after_revised,escalation_no,SUM(CASE WHEN budget_type = 'material' THEN amount_after_revised ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN amount_after_revised ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN amount_after_revised ELSE 0 END) AS material_labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'other' THEN amount_after_revised ELSE 0 END) AS other_total_cost")
                ->selectRaw("increased_or_decreased_amount,SUM(CASE WHEN budget_type = 'material' THEN increased_or_decreased_amount ELSE 0 END) AS material_changed_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN increased_or_decreased_amount ELSE 0 END) AS labour_changed_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN increased_or_decreased_amount ELSE 0 END) AS material_labour_changed_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'other' THEN increased_or_decreased_amount ELSE 0 END) AS other_changed_total_cost")
                ->groupBy('escalation_no')
                ->get();
            //dd($price_escalations);

            return view('boq.departments.civil.home', compact('project','all_cost_summary',
            'total_cost','total_area','price_escalations'));


        } catch (\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function showRevisedSheet($project,$escalation_no){
        try {
            $project = Project::find($project);

            $escalations = BoqCivilRevisedSheet::where('project_id',$project->id)
                ->where('escalation_no',$escalation_no)->with('material.unit','floorProject.floor')
                ->orderBy('boq_floor_id','asc')
                ->get();
            //dd($escalations);

            return view('boq.departments.civil.show-revised-sheet', compact('project','escalation_no','escalations'));
        } catch (\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
