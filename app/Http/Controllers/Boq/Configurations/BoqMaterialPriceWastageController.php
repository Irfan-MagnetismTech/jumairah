<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqMaterialPriceWastageEditRequest;
use App\Http\Requests\Boq\BoqMaterialPriceWastageRequest;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;

class BoqMaterialPriceWastageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * @param Project $project
     */
    public function index(Project $project)
    {
        $material_price_wastages = BoqMaterialPriceWastage::with('nestedMaterial')->get();

        $material_price_wastages = $material_price_wastages->sortBy('nestedMaterial.name');

        // $material_price_wastages sorted by material name

        return view('boq.departments.civil.configurations.materialpricewastage.index', compact('material_price_wastages', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $consumable_cost_heads = BoqMaterialPriceWastage::where('is_other_cost', 1)
            ->groupBy('other_material_head')
            ->orderBy('other_material_head')
            ->get();

        //$nested_materials = NestedMaterial::get()->toTree();
        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();

        return view('boq.departments.civil.configurations.materialpricewastage.create', compact('nested_materials', 'project',
        'consumable_cost_heads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, BoqMaterialPriceWastageRequest $request)
    {
        try {
            foreach ($request->nested_material_id as $key => $materialId) {
                $obj = new BoqMaterialPriceWastage();
                $obj->price = $request->price[$key];
                $obj->project_id = $request->project_id;
                $obj->nested_material_id = $materialId;
                $obj->is_other_cost = $request->is_other_cost;
                $obj->other_material_head = $request->other_material_head ? $request->other_material_head : '---';
                $obj->save();
            }

            return redirect()->route('boq.project.departments.civil.configurations.material-price-wastage.index', $project)
                ->withMessage('Material price saved successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, BoqMaterialPriceWastage $materialPriceWastage)
    {
        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();


        $consumable_cost_heads = BoqMaterialPriceWastage::where('is_other_cost', 1)
            ->groupBy('other_material_head')
            ->orderBy('other_material_head')
            ->get();

        //dd($materialPriceWastage);

        //dd($nested_materials);

        return view('boq.departments.civil.configurations.materialpricewastage.edit-form', compact('nested_materials', 'materialPriceWastage', 'project',
        'consumable_cost_heads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, BoqMaterialPriceWastage $materialPriceWastage, Request $request)
    {
        try {
            $materialPriceWastage->update($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.material-price-wastage.index', $project)
                ->withMessage('Material price updated successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, BoqMaterialPriceWastage $materialPriceWastage)
    {
        try {
            $materialPriceWastage->delete();

            return redirect()->route('boq.project.departments.civil.configurations.material-price-wastage.index', $project)
                ->withMessage('Material price deleted successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

}
