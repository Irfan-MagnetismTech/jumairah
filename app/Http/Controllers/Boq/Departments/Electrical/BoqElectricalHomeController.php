<?php

namespace App\Http\Controllers\Boq\Departments\Electrical;

use App\Boq\Departments\Eme\BoqEmeBudget;
use App\Boq\Departments\Eme\BoqEmeCalculation;
use App\Http\Controllers\Controller;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;

class BoqElectricalHomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Project $project)
    {
        $budgets = BoqEmeBudget::where('project_id', $project->id)->get();
        $BoqEmeCalculationDetails = BoqEmeCalculation::where('project_id', $project->id)->get();
        $BoqEmeCalculationItemData = $BoqEmeCalculationDetails->groupBy('item_id')
            ->map(function ($items, $key) {
                $parentMaterial = NestedMaterial::where('id', $key)->first();
                $items['itemName'] = $parentMaterial->name;
                $items['total_material_amount'] = $items->sum('total_material_amount');
                $items['total_labour_amount']   = $items->sum('total_labour_amount');
                return $items;
            });
        return view('boq.departments.electrical.home', compact('project', 'budgets','BoqEmeCalculationItemData', 'BoqEmeCalculationDetails'));
    }
}
