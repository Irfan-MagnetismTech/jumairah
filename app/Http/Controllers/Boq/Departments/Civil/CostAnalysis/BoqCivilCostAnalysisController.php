<?php

namespace App\Http\Controllers\Boq\Departments\Civil\CostAnalysis;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use App\Http\Services\CivilAnalysisService;
use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoqCivilCostAnalysisController extends Controller
{
    /**
     * @param Project $project
     */
    public function materialStatementFloorWise(Project $project)
    {
        try
        {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit'])
                ->where('budget_type', 'material')
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'nestedMaterial.name']);

            return view('boq.departments.civil.costanalysis.floorwise.material-statement', compact('project', 'material_statements'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * @param Project $project
     */
    public function materialStatementWorkWise(Project $project, Request $request): View
    {

        try
        {
            $material_statements = (new CivilAnalysisService())->getMaterialStatementWorkWise($project, $request);

            return view('boq.departments.civil.costanalysis.workwise.material-statement', compact('project', 'material_statements'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * @param Project $project
     */
    public function materialCostFloorWise(Project $project, Request $request)
    {

        try
        {
            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'material')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'material')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getMaterialStatementWorkWise($project,$request);


            return view('boq.departments.civil.costanalysis.floorwise.material-cost', compact('project', 'material_statements',
            'boq_calc_floors','boq_calc_works'));
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * @param Project $project
     */
    public function labourCostFloorWise(Project $project,Request $request)
    {

        try
        {
            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'labour')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'labour')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getLabourStatementWorkWise($project,$request);

            return view('boq.departments.civil.costanalysis.floorwise.labour-cost', compact('project', 'material_statements',
            'boq_calc_floors','boq_calc_works'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    /**
     * @param Project $project
     */
    public function materialLabourCostFloorWise(Project $project, Request $request)
    {

        try
        {

            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'material-labour')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'material-labour')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getMaterialLabourStatementWorkWise($project,$request);

            return view('boq.departments.civil.costanalysis.floorwise.material-labour-cost', compact('project', 'material_statements',
            'boq_calc_floors', 'boq_calc_works'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }


    public function relatedMaterialCost(Project $project)
    {

        try
        {
            $material_statements = $project->boqCivilBudgets()
                ->with('nestedMaterial.unit')
                ->where('budget_type', 'other')
                ->where('total_amount' , '>', 0)
                ->get()
                ->groupBy('cost_head');

            //sort by nested material name
            $material_statements = $material_statements->map(function ($item) {
                return $item->sortBy('nestedMaterial.name');
            });

            //dd($material_statements);

            return view('boq.departments.civil.costanalysis.related-material-cost', compact('project', 'material_statements'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    /**
     * @param Project $project
     * @return mixed
     */
    public function percentageSheetWorkWise(Project $project)

    {

        try
        {
            $total_areas  = $project->boqFloorProjects()->sum('area');

            $percentage_sheet_work_wise = $project->boqCivilBudgets()
                ->selectRaw("*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount")
                ->with('boqWork')
                ->groupBy('boq_work_parent_id')
                ->where('budget_type', '!=', 'other')
                ->get();

            $percentage_sheet_work_wise = $percentage_sheet_work_wise->sortBy('boq_floor_type_id');

            $percentage_sheet_work_wise = $percentage_sheet_work_wise->groupBy('boqParentWork.name')
                ->map(function ($item, $key) use ($total_areas) {
                    $item->material_total_amount = $item->sum('material_total_amount');
                    $item->labour_total_amount   = $item->sum('labour_total_amount');
                    $item->material_labour_total_amount = $item->sum('material_labour_total_amount');
                    $item->total_amount = $item->sum('material_total_amount') + $item->sum('labour_total_amount') + $item->sum('material_labour_total_amount');
                    $item->cost_per_sft = ($item->total_amount / $total_areas);
                    return $item;
                });

            $other_related_costs = $project->boqCivilBudgets()
                ->where('budget_type', 'other')
                ->sum('total_amount');

            $total_cost = $percentage_sheet_work_wise->sum(function ($sheet)
            {
                return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount;
            });

            $total_cost += $other_related_costs;

            return view('boq.departments.civil.costanalysis.percentagesheet.workwise', compact('project', 'percentage_sheet_work_wise',
                'total_areas', 'total_cost', 'other_related_costs'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * @param Project $project
     * @return mixed
     */
    public function percentageSheetFloorWise(Project $project)
    {

        try
        {
            $total_areas                 = $project->boqFloorProjects()->sum('area');
            $percentage_sheet_floor_wise = $project->boqCivilBudgets()
                ->selectRaw("*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount")
                ->groupBy('boq_floor_id')
                ->where('budget_type', '!=', 'other')
                ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                ->get();


            $percentage_sheet_floor_wise = $percentage_sheet_floor_wise->sortBy('boq_floor_type_id');

            $other_related_costs = $project->boqCivilBudgets()
                ->where('budget_type', 'other')
                ->sum('total_amount');

            $total_cost = $percentage_sheet_floor_wise->sum(function ($sheet) use($other_related_costs)
            {
                return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount;
            });

            $total_cost += $other_related_costs;

            return view('boq.departments.civil.costanalysis.percentagesheet.floorwise-v2', compact('project', 'percentage_sheet_floor_wise',
                'total_areas', 'total_cost', 'other_related_costs'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * @param Project $project
     * @return mixed
     */
    public function materialSummary(Project $project, Request $request)
    {
        try
        {

            $total_areas = $project->boqFloorProjects()->sum('area');

//            $material_statements = $project->boqCivilBudgets()->where('budget_type','!=','labour')
//                ->where('quantity','!=',0)
//                ->groupBy('nested_material_id')
//                ->selectRaw('*, SUM(total_quantity) as gross_total_quantity')
//                ->with('nestedMaterial.unit')
//                ->get();
//
//            $material_statements = $material_statements->sortBy('nestedMaterial.name');
//
//            $material_list = $material_statements;
//
//            // $material_statements if request nested_material_id is not null
//            if($request->nested_material_id){
//                $material_statements = $material_statements->where('nested_material_id', $request->nested_material_id);
//            }
//
//            $floor_wise_group = $material_statements->map(function ($material) use ($project) {
//                $floors = $project->boqCivilBudgets()
//                    ->where('nested_material_id', $material->nested_material_id)
//                    //->whereNotIn('budget_type', ['labour', 'other])
//                    ->where('budget_type','!=','labour')
//                    ->where('quantity', '>', 0)
//                    ->groupBy('boq_floor_id')
//                    ->selectRaw('*, SUM(total_quantity) as gross_total_quantity')
//                    ->with('boqCivilCalcProjectFloor.boqCommonFloor')
//                    ->get();
//
//                return [
//                    'material_id' => $material?->nestedMaterial?->id,
//                    'material_name' => $material?->nestedMaterial?->name,
//                    'material_unit' => $material?->nestedMaterial?->unit?->name,
//                    'floors' => $floors,
//                    'total_quantity' => $floors->sum('gross_total_quantity'),
//                ];
//            });
//
//            $material_statements = collect($floor_wise_group)->sortBy('floor_id')->values()->all();

            $material_statements = $project->boqSupremeBudgets()->where('budget_type','!=','labour')
                ->where('quantity','!=',0)
                ->groupBy('material_id')
                ->selectRaw('*, SUM(quantity) as gross_total_quantity')
                ->with('nestedMaterial.unit')
                ->get();


            //dd($material_statements);

            $material_statements = $material_statements->sortBy('nestedMaterial.name');

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if($request->nested_material_id){
                $material_statements = $material_statements->where('material_id', $request->nested_material_id);
            }

            $floor_wise_group = $material_statements->map(function ($material) use ($project) {
                $floors = $project->boqSupremeBudgets()
                    ->where('material_id', $material->material_id)
                    ->where('budget_type','!=','labour')
                    ->where('quantity', '>', 0)
                    ->groupBy('floor_id')
                    ->selectRaw('*, SUM(quantity) as gross_total_quantity')
                    ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                    ->get();

                return [
                    'material_id' => $material?->nestedMaterial?->id,
                    'material_name' => $material?->nestedMaterial?->name,
                    'material_status' => $material?->nestedMaterial?->material_status,
                    'material_unit' => $material?->nestedMaterial?->unit?->name,
                    'floors' => $floors,
                    'total_quantity' => $floors->sum('gross_total_quantity'),
                ];
            });

            $material_statements = collect($floor_wise_group)->sortBy('floor_id')->values()->all();

            return view('boq.departments.civil.costanalysis.summary-sheet', compact('project','total_areas','material_statements','material_list'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function reinforcementSheet(Project $project){

        try {

//            $total_areas = $project->boqFloorProjects()->sum('area');
//
//            $reinforcement_sheet = $project->boqReinforcementBudgets()
//                ->with('boqReinforcementProjectFloor.boqCommonFloor')
//                ->get();
//
//            $reinforcement_sheet = $reinforcement_sheet->sortBy('boq_floor_id');
//
//            $reinforcement_sheet = $reinforcement_sheet->groupBy('boq_floor_id')
//                ->map(function ($floor_items, $floor_key) {
//                    $dia_groups = $floor_items->groupBy('dia');
//                    $dia_totals = $dia_groups->map(function ($dia_items, $dia_key) {
//                        $total_quantity = $dia_items->sum('total_quantity');
//                        return ['dia' => $dia_key, 'total_quantity' => $total_quantity];
//                    });
//                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $floor_key)->with('boqCommonFloor')->first();
//                    return ['boq_floor' => $boq_floor, 'dia_totals' => $dia_totals];
//                });
//
//            dd($reinforcement_sheet);
//
//            return view('boq.departments.civil.costanalysis.reinforcement-sheet', compact('project','total_areas','reinforcement_sheet'));
//        }
//        catch (\Exception $e)
//        {
//            return redirect()->back()->withError($e->getMessage());
//        }

            $reinforcement_sheet = $project->boqReinforcementBudgets()
                ->with('boqReinforcementProjectFloor.boqCommonFloor')
                ->get();

            $reinforcement_sheet = $reinforcement_sheet->groupBy('boq_floor_id')
                ->map(function ($floor_items, $floor_key) {
                    $dia_groups = $floor_items->groupBy('dia');
                    $dia_totals = $dia_groups->map(function ($dia_items, $dia_key) {
                        //dd($dia_key);
                        $total_quantity = $dia_items->sum('total_quantity');
                        return ['dia' => $dia_key, 'total_quantity' => $total_quantity];
                    });
                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $floor_key)->with('boqCommonFloor')->first();
                    return ['floor_id' => $boq_floor?->boqCommonFloor?->id, 'floor_name' => $boq_floor?->boqCommonFloor?->name, 'dia_totals' => $dia_totals];
                });

            //sort by dia in each floor
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) {
                $dia_totals = $floor_items['dia_totals'];
                $dia_totals = $dia_totals->sortBy('dia');
                $floor_items['dia_totals'] = $dia_totals;
                return $floor_items;
            });

            $diaList = collect([8, 10, 12, 16, 20, 22, 25, 32]);

            //check diaList is present in each floor
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) use ($diaList) {
                $dia_totals = $floor_items['dia_totals'];
                $dia_totals = $diaList->map(function ($dia) use ($dia_totals) {
                    $dia_total = $dia_totals->where('dia', $dia)->first();
                    return $dia_total ? $dia_total : ['dia' => $dia, 'total_quantity' => 0];
                });
                $floor_items['dia_totals'] = $dia_totals;
                return $floor_items;
            });

            //dia wise total quantity boq reinforcement sheet
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) use ($diaList) {
                $dia_totals = $floor_items['dia_totals'];
                //sum of dia wise total quantity
                $total_quantity = $dia_totals->sum('total_quantity');
                $floor_items['floorwise_dia_totals'] = $total_quantity;
                return $floor_items;
            });

            //dia wise total quantity boq reinforcement sheet
            $diaWiseTotal = $project->boqReinforcementBudgets()->groupBy('dia')->selectRaw('dia,total_quantity, SUM(total_quantity) as total_quantity')->get();
            $diaWiseTotal = $diaWiseTotal->sortBy('dia');
            $diaWiseTotal = $diaList->map(function ($dia) use ($diaWiseTotal) {
                $dia_total = $diaWiseTotal->where('dia', $dia)->first();
                return $dia_total ? $dia_total : ['dia' => $dia, 'total_quantity' => 0];
            });

            //floor wise total quantity boq reinforcement sheet
            $floorWiseTotal = $project->boqReinforcementBudgets()
                ->with('boqReinforcementProjectFloor.boqCommonFloor')
                ->get();

            $floorWiseTotal = $floorWiseTotal->sortBy('boq_floor_type_id');

            $floorWiseTotal = $floorWiseTotal->groupBy('boq_floor_id')
                ->map(function ($floor_items, $floor_key) {
                    $total_quantity = $floor_items->sum('total_quantity');
                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $floor_key)->with('boqCommonFloor')->first();
                    return ['floor_id' => $boq_floor?->boqCommonFloor?->id ,'floor_name' => $boq_floor?->boqCommonFloor?->name, 'total_quantity' => $total_quantity];
                });


            $reinforcement_sheet = $reinforcement_sheet->sortBy('floor_id');

            return view('boq.departments.civil.costanalysis.reinforcement-sheet', compact('project','reinforcement_sheet',
            'diaWiseTotal','floorWiseTotal'));

        }
        catch (\Exception$e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }


    public function downloadPercentageSheetFloorWise(Project $project){

        try {

            $total_areas                 = $project->boqFloorProjects()->sum('area');
            $percentage_sheet_floor_wise = $project->boqCivilBudgets()
                ->selectRaw("*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount")
                ->groupBy('boq_floor_id')
                ->where('budget_type', '!=', 'other')
                ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                ->get();


            $percentage_sheet_floor_wise = $percentage_sheet_floor_wise->sortBy('boq_floor_type_id');

            $other_related_costs = $project->boqCivilBudgets()
                ->where('budget_type', 'other')
                ->sum('total_amount');

            $total_cost = $percentage_sheet_floor_wise->sum(function ($sheet) use($other_related_costs)
            {
                return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount;
            });

            $total_cost += $other_related_costs;

            return PDF::loadview('boq.departments.civil.costanalysis.percentagesheet.download-floorwise', compact(
                'project', 'percentage_sheet_floor_wise',
                'total_areas', 'total_cost', 'other_related_costs'
            ))->stream('floorwise-percentage-sheet.pdf');

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function downloadPercentageSheetWorkWise(Project $project){

        try {

            $total_areas  = $project->boqFloorProjects()->sum('area');

            $percentage_sheet_work_wise = $project->boqCivilBudgets()
                ->selectRaw("*,SUM(CASE WHEN budget_type = 'material' THEN total_amount ELSE 0 END) AS material_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'labour' THEN total_amount ELSE 0 END) AS labour_total_amount, " .
                    "SUM(CASE WHEN budget_type = 'material-labour' THEN total_amount ELSE 0 END) AS material_labour_total_amount")
                ->with('boqWork')
                ->groupBy('boq_work_parent_id')
                ->where('budget_type', '!=', 'other')
                ->get();

            $percentage_sheet_work_wise = $percentage_sheet_work_wise->sortBy('boq_floor_type_id');

            $percentage_sheet_work_wise = $percentage_sheet_work_wise->groupBy('boqParentWork.name')
                ->map(function ($item, $key) use ($total_areas) {
                    $item->material_total_amount = $item->sum('material_total_amount');
                    $item->labour_total_amount   = $item->sum('labour_total_amount');
                    $item->material_labour_total_amount = $item->sum('material_labour_total_amount');
                    $item->total_amount = $item->sum('material_total_amount') + $item->sum('labour_total_amount') + $item->sum('material_labour_total_amount');
                    $item->cost_per_sft = ($item->total_amount / $total_areas);
                    return $item;
                });

            $other_related_costs = $project->boqCivilBudgets()
                ->where('budget_type', 'other')
                ->sum('total_amount');

            $total_cost = $percentage_sheet_work_wise->sum(function ($sheet)
            {
                return $sheet->material_total_amount + $sheet->labour_total_amount + $sheet->material_labour_total_amount;
            });

            $total_cost += $other_related_costs;

            return PDF::loadview('boq.departments.civil.costanalysis.percentagesheet.download-workwise', compact(
                'project', 'percentage_sheet_work_wise',
                'total_areas', 'total_cost', 'other_related_costs'
            ))->stream('workwise-percentage-sheet.pdf');

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }


    public function downloadMaterialCostFloorWise(Project $project,Request $request){

        try
        {
            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'material')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'material')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getMaterialStatementWorkWise($project,$request);

            return PDF::loadview('boq.departments.civil.costanalysis.floorwise.download-material-cost', compact(
                'project', 'material_statements',
                'boq_calc_floors','boq_calc_works'
            ))->stream('material-cost-sheet.pdf');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }


    public function downloadLabourCostFloorWise(Project $project,Request $request){

        try
        {
            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'labour')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'labour')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getLabourStatementWorkWise($project,$request);

            return PDF::loadview('boq.departments.civil.costanalysis.floorwise.download-labour-cost', compact(
                'project', 'material_statements',
                'boq_calc_floors','boq_calc_works'
            ))->stream('labour-cost-sheet.pdf');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function downloadMaterialLabourCostFloorWise(Project $project,Request $request){

        try
        {
            $boq_calc_floors = $project->boqCivilBudgets()
                ->where('budget_type', 'material-labour')
                ->groupBy('boq_floor_id')
                ->with('boqCivilCalcProjectFloor.floor')
                ->get();

            $boq_calc_works = $project->boqCivilBudgets()
                ->where('budget_type', 'material-labour')
                ->groupBy('boq_work_parent_id')
                ->with('boqParentWork')
                ->get();

            $material_statements = (new CivilAnalysisService())->getMaterialLabourStatementWorkWise($project,$request);

            return PDF::loadview('boq.departments.civil.costanalysis.floorwise.download-material-labour-cost', compact(
                'project', 'material_statements',
                'boq_calc_floors', 'boq_calc_works'
            ))->stream('material-labour-cost-sheet.pdf');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function downloadRelatedMaterialCostFloorWise(Project $project,Request $request){

        try
        {
            $material_statements = $project->boqCivilBudgets()
                ->with('nestedMaterial.unit')
                ->where('budget_type', 'other')
                ->where('total_amount' , '>', 0)
                ->get()
                ->groupBy('cost_head');

            //sort by nested material name
            $material_statements = $material_statements->map(function ($item) {
                return $item->sortBy('nestedMaterial.name');
            });

            return PDF::loadview('boq.departments.civil.costanalysis.download-related-material-cost', compact(
                'project', 'material_statements'
            ))->stream('related-material-cost-sheet.pdf');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withError($e->getMessage());
        }

    }


    public function msRodPdf(Project $project){

        try {

            $reinforcement_sheet = $project->boqReinforcementBudgets()
                ->with('boqReinforcementProjectFloor.boqCommonFloor')
                ->get();

            $reinforcement_sheet = $reinforcement_sheet->groupBy('boq_floor_id')
                ->map(function ($floor_items, $floor_key) {
                    $dia_groups = $floor_items->groupBy('dia');
                    $dia_totals = $dia_groups->map(function ($dia_items, $dia_key) {
                        //dd($dia_key);
                        $total_quantity = $dia_items->sum('total_quantity');
                        return ['dia' => $dia_key, 'total_quantity' => $total_quantity];
                    });
                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $floor_key)->with('boqCommonFloor')->first();
                    return ['floor_id' => $boq_floor?->boqCommonFloor?->id, 'floor_name' => $boq_floor?->boqCommonFloor?->name, 'dia_totals' => $dia_totals];
                });

            //sort by dia in each floor
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) {
                $dia_totals = $floor_items['dia_totals'];
                $dia_totals = $dia_totals->sortBy('dia');
                $floor_items['dia_totals'] = $dia_totals;
                return $floor_items;
            });

            $diaList = collect([8, 10, 12, 16, 20, 22, 25, 32]);

            //check diaList is present in each floor
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) use ($diaList) {
                $dia_totals = $floor_items['dia_totals'];
                $dia_totals = $diaList->map(function ($dia) use ($dia_totals) {
                    $dia_total = $dia_totals->where('dia', $dia)->first();
                    return $dia_total ? $dia_total : ['dia' => $dia, 'total_quantity' => 0];
                });
                $floor_items['dia_totals'] = $dia_totals;
                return $floor_items;
            });

            //dia wise total quantity boq reinforcement sheet
            $reinforcement_sheet = $reinforcement_sheet->map(function ($floor_items, $floor_key) use ($diaList) {
                $dia_totals = $floor_items['dia_totals'];
                //sum of dia wise total quantity
                $total_quantity = $dia_totals->sum('total_quantity');
                $floor_items['floorwise_dia_totals'] = $total_quantity;
                return $floor_items;
            });

            //dia wise total quantity boq reinforcement sheet
            $diaWiseTotal = $project->boqReinforcementBudgets()->groupBy('dia')->selectRaw('dia,total_quantity, SUM(total_quantity) as total_quantity')->get();
            $diaWiseTotal = $diaWiseTotal->sortBy('dia');
            $diaWiseTotal = $diaList->map(function ($dia) use ($diaWiseTotal) {
                $dia_total = $diaWiseTotal->where('dia', $dia)->first();
                return $dia_total ? $dia_total : ['dia' => $dia, 'total_quantity' => 0];
            });

            //floor wise total quantity boq reinforcement sheet
            $floorWiseTotal = $project->boqReinforcementBudgets()
                ->with('boqReinforcementProjectFloor.boqCommonFloor')
                ->get();

            $floorWiseTotal = $floorWiseTotal->sortBy('boq_floor_type_id');

            $floorWiseTotal = $floorWiseTotal->groupBy('boq_floor_id')
                ->map(function ($floor_items, $floor_key) {
                    $total_quantity = $floor_items->sum('total_quantity');
                    $boq_floor = BoqFloorProject::where('boq_floor_project_id', $floor_key)->with('boqCommonFloor')->first();
                    return ['floor_id' => $boq_floor?->boqCommonFloor?->id ,'floor_name' => $boq_floor?->boqCommonFloor?->name, 'total_quantity' => $total_quantity];
                });


            $reinforcement_sheet = $reinforcement_sheet->sortBy('floor_id');



//            $boqCivilBugets = BoqCivilCalc::query()
//                ->where('calculation_type', '!=', 'labour')
//                ->whereProjectId($project->id)
//                ->with('boqCivilCalcWork.ancestors:id,_lft,_rgt,parent_id,name,unit_id', 'boqCivilCalcProjectFloor.floor')
//                ->get()
//                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//                ->groupBy('boq_floor_id');

            $pdf = new PDF();
            return PDF::loadview('boq.departments.civil.costanalysis.ms-rod-pdf', compact(
                'project',
                'reinforcement_sheet', 'pdf','diaWiseTotal','floorWiseTotal'
            ))->stream('ms-rod.pdf');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }


    public function downloadMaterialSummary(Project $project, Request $request)
    {

        try
        {

            $total_areas = $project->boqFloorProjects()->sum('area');

            $material_statements = $project->boqCivilBudgets()->where('budget_type','!=','labour')
                ->where('budget_type','!=','other')
                ->where('quantity','!=',0)
                ->groupBy('nested_material_id')
                ->selectRaw('*, SUM(total_quantity) as gross_total_quantity')
                ->with('nestedMaterial.unit')
                ->get();

            $material_statements = $material_statements->sortBy('nestedMaterial.name');

            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if($request->nested_material_id){
                $material_statements = $material_statements->where('nested_material_id', $request->nested_material_id);
            }

            $floor_wise_group = $material_statements->map(function ($material) use ($project) {
                $floors = $project->boqCivilBudgets()
                    ->where('nested_material_id', $material->nested_material_id)
                    ->whereNotIn('budget_type', ['labour', 'other'])
                    ->where('quantity', '>', 0)
                    ->groupBy('boq_floor_id')
                    ->selectRaw('*, SUM(total_quantity) as gross_total_quantity')
                    ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                    ->get();

                return [
                    'material_id' => $material?->nestedMaterial?->id,
                    'material_name' => $material?->nestedMaterial?->name,
                    'material_unit' => $material?->nestedMaterial?->unit?->name,
                    'floors' => $floors,
                    'total_quantity' => $floors->sum('gross_total_quantity'),
                ];
            });

            $material_statements = collect($floor_wise_group)->sortBy('floor_id')->values()->all();

            $pdf = new PDF();
            return PDF::loadview('boq.departments.civil.costanalysis.summary-sheet-pdf', compact(
                'project',
                'total_areas', 'material_statements', 'pdf','material_list'
            ))->stream('ms-rod.pdf');

            //return response()->json($material_statements);

            return view('boq.departments.civil.costanalysis.summary-sheet', compact('project','total_areas','material_statements','material_list'));
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

}
