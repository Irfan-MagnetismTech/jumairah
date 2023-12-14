<?php

namespace App\Http\Controllers\Boq\Departments\Civil\CostAnalysis;

use App\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Boq\Configurations\BoqWork;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Boq\Departments\Civil\BoqCivilBudget;

class BoqCivilWorkQuantityController extends Controller
{
    public function index(Project $project)
    {
//        $boqCivilBugets = BoqCivilCalc::query()
//            ->where('calculation_type', '!=', 'labour')
//            ->whereProjectId($project->id)
//            ->with('boqCivilCalcWork.ancestors:id,_lft,_rgt,parent_id,name,unit_id', 'boqCivilCalcProjectFloor.floor')
//            ->get()
//            ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//            ->groupBy('boq_floor_id');

        // $boqCivilBudgets = BoqCivilCalc::where('calculation_type', '!=', 'labour')
        //     ->whereProjectId($project->id)
        //     ->with('boqCivilCalcWork.boqWorkUnit','boqCivilCalcProjectFloor.floor')
        //     ->get()
        //     ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
        //     ->groupBy('work_id')
        //     ->map(function ($group) {
        //         return [
        //             "work_items" => $group,
        //             "total_quantity" => $group->sum('total'),
        //         ];
        //     });

        $query = BoqCivilCalc::where('calculation_type', '!=', 'labour')
        ->whereProjectId($project->id)
        ->with('boqCivilCalcWork.boqWorkUnit','boqCivilCalcProjectFloor.floor')
        ->get()
        ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no');

    if ($work_id = request('work_id')) {
        $boqCivilBudgets = $query->where('work_id', $work_id)
            ->groupBy('work_id')
            ->map(function ($group) {
                return [
                    "work_items" => $group,
                    "total_quantity" => $group->sum('total'),
                ];
            });
    } else {
        $boqCivilBudgets = $query->groupBy('work_id')
            ->map(function ($group) {
                return [
                    "work_items" => $group,
                    "total_quantity" => $group->sum('total'),
                ];
            });
    }

        return view('boq.departments.civil.costanalysis.work-quantity.index', compact('project', 'boqCivilBudgets'));
    }

    public function workQuantityPdf(Project $project){

        try {

            $boqCivilBudgets = BoqCivilCalc::query()
                ->where('calculation_type', '!=', 'labour')
                ->whereProjectId($project->id)
                ->with('boqCivilCalcWork.ancestors:id,_lft,_rgt,parent_id,name,unit_id', 'boqCivilCalcProjectFloor.floor')
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy('boq_floor_id');

//            $boqCivilBudgets = BoqCivilCalc::where('calculation_type', '!=', 'labour')
//                ->whereProjectId($project->id)
//                ->with('boqCivilCalcWork.boqWorkUnit','boqCivilCalcProjectFloor.floor')
//                ->get()
//                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//                ->groupBy('work_id')
//                ->map(function ($group) {
//                    return [
//                        "work_items" => $group,
//                        "total_quantity" => $group->sum('total'),
//                    ];
//                });

            $pdf = new PDF();
            return PDF::loadview('boq.departments.civil.costanalysis.work-quantity.work-quantity-pdf', compact(
                'project',
                'boqCivilBudgets',
                'pdf'
            ))->stream('work-quantity.pdf');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
