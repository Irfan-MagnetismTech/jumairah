<?php
namespace App\Http\Services;

use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Project;
use Illuminate\Support\Collection;

class CivilAnalysisService
{
    /**
     * Get ancestors of a work in a recursive manner.
     *
     * @param $work_type_id
     * @return mixed
     */
    private function getAncestorsTillType($work_id, $work_type_id, $ancestors = []): Collection
    {
        $work = BoqWork::find($work_id);
        if ($work_id == $work_type_id)
        {
            return collect($ancestors)->reverse();
        }
        $ancestors[] = $work;

        return $this->getAncestorsTillType($work->parent_id, $work_type_id, $ancestors);
    }

    /**
     * Get Material Statement Work Wise.
     *
     * @param App\Project $project
     * @return mixed
     */
    public function getMaterialStatementWorkWise(Project $project, $request): mixed
    {

        $calc_type    = 'material';
        $calculations = BoqCivilCalc::query()
            ->with('unit')
            ->where('project_id', $project->id)
            ->where('calculation_type', $calc_type)
            ->get();

        if(count($request->all()) > 1) {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->when($request->boq_floor_id != null, function ($q) use($request){
                    return $q->where('boq_floor_id',$request->boq_floor_id);
                })
                ->when($request->boq_work_parent_id != null, function ($q) use($request){
                    return $q->where('boq_work_parent_id',$request->boq_work_parent_id);
                })
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);

        } else {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);
        }

        //dd($material_statements);

//        if($request->boq_floor_id != null){
//            $material_statements = $project->boqCivilBudgets()
//                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
//                ->where('budget_type', $calc_type)
//                ->where('boq_floor_id', $request->boq_floor_id)->where('boq_work_parent_id', $request->boq_work_parent_id)
//                ->get()
//                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);
//        } else {
//            $material_statements = $project->boqCivilBudgets()
//                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
//                ->where('budget_type', $calc_type)
//                ->get()
//                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);
//        }


        foreach ($material_statements as $floor_name => $material_statement)
        {
            foreach ($material_statement as $work_type_id => $works)
            {
                $boq_floor_id = $works?->first()?->first()?->boq_floor_id;
                foreach ($works as $work_id => $work)
                {
                    $ancestors = $this->getAncestorsTillType($work_id, $work_type_id)
                        ->filter(fn($item) => $item->id != $work_id);
                    $calcs = $calculations->where('work_id', $work_id)
                        ->where('boq_floor_id', $boq_floor_id)
                        ->first();
                    $material_statements[$floor_name][$work_type_id][$work_id]->ancestors      = $ancestors;
                    $material_statements[$floor_name][$work_type_id][$work_id]->boq_civil_calc = $calcs;
                }
            }
        }

        return $material_statements;
    }


    public function getLabourStatementWorkWise(Project $project, $request): mixed
    {
        $calc_type    = 'labour';
        $calculations = BoqCivilCalc::query()
            ->with('unit')
            ->where('project_id', $project->id)
            ->where('calculation_type', $calc_type)
            ->get();

        if(count($request->all()) > 1) {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->when($request->boq_floor_id != null, function ($q) use($request){
                    return $q->where('boq_floor_id',$request->boq_floor_id);
                })
                ->when($request->boq_work_parent_id != null, function ($q) use($request){
                    return $q->where('boq_work_parent_id',$request->boq_work_parent_id);
                })
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);

        } else {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);
        }

        foreach ($material_statements as $floor_name => $material_statement)
        {
            foreach ($material_statement as $work_type_id => $works)
            {
                $boq_floor_id = $works->first()->first()->boq_floor_id;
                foreach ($works as $work_id => $work)
                {
                    $ancestors = $this->getAncestorsTillType($work_id, $work_type_id)
                        ->filter(fn($item) => $item->id != $work_id);
                    $calcs = $calculations->where('work_id', $work_id)
                        ->where('boq_floor_id', $boq_floor_id)
                        ->first();
                    $material_statements[$floor_name][$work_type_id][$work_id]->ancestors      = $ancestors;
                    $material_statements[$floor_name][$work_type_id][$work_id]->boq_civil_calc = $calcs;
                }
            }
        }

        return $material_statements;
    }

    public function getMaterialLabourStatementWorkWise(Project $project,$request): mixed
    {
        $calc_type    = 'material-labour';
        $calculations = BoqCivilCalc::query()
            ->with('unit')
            ->where('project_id', $project->id)
            ->where('calculation_type', $calc_type)
            ->get();

        if(count($request->all()) > 1) {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->when($request->boq_floor_id != null, function ($q) use($request){
                    return $q->where('boq_floor_id',$request->boq_floor_id);
                })
                ->when($request->boq_work_parent_id != null, function ($q) use($request){
                    return $q->where('boq_work_parent_id',$request->boq_work_parent_id);
                })
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);

        } else {
            $material_statements = $project->boqCivilBudgets()
                ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
                ->where('budget_type', $calc_type)
                ->get()
                ->sortBy('boqCivilCalcProjectFloor.floor._rgt')
                ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
                ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);
        }

//        $material_statements = $project->boqCivilBudgets()
//            ->with(['boqCivilCalcProjectFloor.floor', 'boqWork.materialUnit', 'boqWork.labourUnit', 'boqWork.materialLabourUnit', 'nestedMaterial.unit', 'workType'])
//            ->where('budget_type', $calc_type)
//            ->get()
//            ->sortBy('boqCivilCalcProjectFloor.floor.floor_type.serial_no')
//            ->groupBy(['boqCivilCalcProjectFloor.floor.name', 'work_type_id', 'boq_work_id']);

        foreach ($material_statements as $floor_name => $material_statement)
        {
            foreach ($material_statement as $work_type_id => $works)
            {
                $boq_floor_id = $works->first()->first()->boq_floor_id;
                foreach ($works as $work_id => $work)
                {
                    $ancestors = $this->getAncestorsTillType($work_id, $work_type_id)
                        ->filter(fn($item) => $item->id != $work_id);
                    $calcs = $calculations->where('work_id', $work_id)
                        ->where('boq_floor_id', $boq_floor_id)
                        ->first();
                    $material_statements[$floor_name][$work_type_id][$work_id]->ancestors      = $ancestors;
                    $material_statements[$floor_name][$work_type_id][$work_id]->boq_civil_calc = $calcs;
                }
            }
        }

        return $material_statements;
    }
}
