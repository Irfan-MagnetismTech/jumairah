<?php

namespace App\Http\Controllers\Boq\Departments\Civil\Cost;

use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Http\Controllers\Controller;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoqCivilConsumableBudgetController extends Controller
{
    private const CONSUMABLE_COST_TYPE = 'other';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $consumables = $project->boqCivilBudgets()
            ->with('nestedMaterial.unit')
            ->where('budget_type', self::CONSUMABLE_COST_TYPE)
            ->where('total_amount', '>', 0)
            ->get()
            ->groupBy('cost_head');

        return view(
            'boq.departments.civil.costs.consumable.consumable-sheet',
            compact('project', 'consumables')
        );

        //        return view('boq.departments.civil.costs.consumable.index',
        //            compact('project', 'consumables')
        //        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {

        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();
//        dd($nodes);
//        $nested_materials = [];
//
        $consumable_cost_heads = BoqMaterialPriceWastage::where('is_other_cost', 1)
            ->groupBy('other_material_head')
            ->orderBy('other_material_head')
            ->get();
//
//        $traverse = function ($all_nested_materials, $prefix = '-') use (&$traverse, &$nested_materials) {
//            foreach ($all_nested_materials as $nested_material) {
//                $nested_materials[$nested_material->id] = $prefix . ' ' . $nested_material->name;
//
//                $traverse($nested_material->children, $prefix . '-');
//            }
//        };
//
//        $traverse($nodes);

        //dd($nested_materials);

        return view('boq.departments.civil.costs.consumable.create', compact('project', 'consumable_cost_heads', 'nested_materials'));
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

            $material_price_wastages = BoqMaterialPriceWastage::where('project_id', $project->id)
                ->whereIn('nested_material_id', $request->nested_material_id)
                ->get()
                ->keyBy('nested_material_id');

            //            if ($material_price_wastages->count('*') != count($request->nested_material_id))
            //            {
            //                $not_in_material_price = BoqMaterialPriceWastage::with('nestedMaterial')
            //                    ->whereNotIn('nested_material_id', $request->nested_material_id)
            //                    ->get()
            //                    ->pluck('nestedMaterial.name')
            //                    ->toArray();
            //
            //                throw new \Exception('Price not found for ' . implode(', ', $not_in_material_price));
            //            }

            DB::transaction(function () use ($request, $project, $material_price_wastages) {
                foreach ($request->nested_material_id as $key => $nested_material_id) {

                    //check if material is already added or not in material wastage table start
                    $material_wastage = BoqMaterialPriceWastage::where('nested_material_id', $nested_material_id)
                        ->first();
                    if($material_wastage == null){
                        $material_wastage = new BoqMaterialPriceWastage();
                        $material_wastage->nested_material_id = $nested_material_id;
                        $material_wastage->project_id = $project->id;
                        $material_wastage->price = $request->rate[$key];
                        $material_wastage->is_other_cost = 1;
                        $material_wastage->other_material_head = $request->cost_head;
                        $material_wastage->save();
                    }
                    //check if material is already added or not in material wastage table end

                    BoqCivilBudget::updateOrCreate(
                        [
                            'project_id'         => $project->id,
                            'nested_material_id' => $nested_material_id,
                            'cost_head'          => $request->cost_head,
                            'budget_type'        => self::CONSUMABLE_COST_TYPE,
                        ],
                        [
                            'quantity'       => $request->quantity[$key],
                            'rate'           => $request->rate[$key],
                            'total_quantity' => $request->quantity[$key],
                            'total_amount'   => $request->rate[$key] * $request->quantity[$key],
                            'cost_head'      => $request->cost_head,
                        ]
                    );

                    /* Update Boq Supreme budget start */
                    $project->boqSupremeBudgets()->where('budget_type', self::CONSUMABLE_COST_TYPE)
                        ->where('material_id', $nested_material_id)
                        ->delete();
                    //$this->request['budget_for'] = 'Civil';
                    $project->boqSupremeBudgets()->updateOrCreate(
                        [
                            'material_id'        => $nested_material_id,
                            'budget_type'        => 'other',
                            'budget_for'         => 'Civil',
                            'floor_id'           => $request->cost_head,
                        ],
                        [
                            'quantity'     => $request->quantity[$key],
                            'budget_type'  => 'other',
                            'floor_id'     => $request->cost_head,
                        ]
                    );
                    /* Update Boq Supreme budget end */
                }
            });

            if($request->selected_head !== null){
                return redirect()->route('boq.project.departments.civil.cost_analysis.floor_wise.related_material.costs', $project)
                    ->withMessage('Consumable cost updated successfully.');
            }

            return redirect()->back()->withMessage('Consumable cost saved successfully.');


//
//            return redirect()->route('boq.project.departments.civil.costs.consumables.index', $project)
//                ->withMessage('Consumable cost saved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('boq.project.departments.civil.costs.consumables.create', $project)
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, BoqCivilBudget $consumable)
    {
        $nodes            = NestedMaterial::get()->toTree();
        $nested_materials = [];

        $traverse = function ($all_nested_materials, $prefix = '-') use (&$traverse, &$nested_materials) {
            foreach ($all_nested_materials as $nested_material) {
                $nested_materials[$nested_material->id] = $prefix . ' ' . $nested_material->name;

                $traverse($nested_material->children, $prefix . '-');
            }
        };

        $traverse($nodes);

        return view('boq.departments.civil.costs.consumable.edit', compact(
            'project',
            'consumable',
            'nested_materials'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, BoqCivilBudget $consumable)
    {
        try {
            $material_price_wastages = BoqMaterialPriceWastage::where('project_id', $project->id)
                ->where('nested_material_id', $request->nested_material_id)
                ->first();

            if ($material_price_wastages === null) {
                throw new \Exception('Price not found for ' . NestedMaterial::find($request->nested_material_id)->name);
            }

            $consumable->update([
                'nested_material_id' => $request->nested_material_id,
                'quantity'           => $request->quantity,
                'total_quantity'     => $request->quantity,
                'total_amount'       => $material_price_wastages->price * $request->quantity,
            ]);

            /* Update Boq Supreme budget start */
            $project->boqSupremeBudgets()->where('budget_type', self::CONSUMABLE_COST_TYPE)
                ->where('material_id', $request->nested_material_id)
                ->delete();

            $project->boqSupremeBudgets()->updateOrCreate(
                [
                    'material_id'        => $request->nested_material_id,
                    'budget_type'        => self::CONSUMABLE_COST_TYPE,
                    'budget_for'         => 'Civil',
                ],
                [
                    'quantity'     =>  $request->quantity,
                    'budget_type'  => self::CONSUMABLE_COST_TYPE,
                ]
            );
            /* Update Boq Supreme budget end */

            return redirect()->route('boq.project.departments.civil.costs.consumables.index', $project)
                ->withMessage('Consumable cost saved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('boq.project.departments.civil.costs.consumables.create', $project)
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, BoqCivilBudget $consumable)
    {
        try {
            $consumable->delete();

            return redirect()->route('boq.project.departments.civil.costs.consumables.index', $project)
                ->withMessage('Consumable cost saved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('boq.project.departments.civil.costs.consumables.create', $project)
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function editConsumableBudgetWithHead(Project $project, $selectedHead){

//        $nodes            = NestedMaterial::get()->toTree();
//        $nested_materials = [];
        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();

        $consumable_cost_heads = BoqMaterialPriceWastage::groupBy('other_material_head')
            ->orderBy('other_material_head', 'ASC')->get();

//        $traverse = function ($all_nested_materials, $prefix = '-') use (&$traverse, &$nested_materials) {
//            foreach ($all_nested_materials as $nested_material) {
//                $nested_materials[$nested_material->id] = $prefix . ' ' . $nested_material->name;
//
//                $traverse($nested_material->children, $prefix . '-');
//            }
//        };
//
//        $traverse($nodes);

        return view('boq.departments.civil.costs.consumable.create', compact('project', 'consumable_cost_heads', 'nested_materials', 'selectedHead'));

    }
}
