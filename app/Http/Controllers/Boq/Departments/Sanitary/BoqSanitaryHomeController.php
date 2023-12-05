<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\ProjectWiseMaterial;
use App\Boq\Departments\Sanitary\SanitaryMaterialRate;
use App\Http\Controllers\Controller;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BoqSanitaryHomeController extends Controller
{
    public function __invoke(Request $request, Project $project)
    {
        // Session::get('project_id')
        Session::put('project_id', $project->id);
        Session::put('project_name', $project->name);
//        dd($project, $project->sanitaryBudgetSummary);
        $summariesData = NestedMaterial::whereNull('parent_id')->orderBy('name')
            ->where('account_id',123)->get()
            ->map(function ($item) use ($project){
                $sanitaryMaterials = ProjectWiseMaterial::with('projectWiseMaterialDetails')->where('project_id', $project->id)
                    ->whereHas('materialSecond', function ($q) use($item){
                        $q->where('parent_id', $item->id);
                    })->get();
                    $amount=0;
                    foreach ($sanitaryMaterials->pluck('projectWiseMaterialDetails') as $materialsRateDetails){
                        foreach ($materialsRateDetails as $materialsRateDetail){
                            $rate = $materialsRateDetail->quantity * $materialsRateDetail->material_rate ;
                            $amount += $rate;
                        }
                    }
                     $item['amount'] = $amount;
                    return $item;
            });

//        dd($summariesData);

        return view('boq.departments.sanitary.home', compact('summariesData', 'project'));
    }
}
