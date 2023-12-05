<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqMaterialPriceWastageEditRequest;
use App\Http\Requests\Boq\BoqMaterialPriceWastageRequest;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;

class BoqProjectWiseMaterialPriceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * @param Project $project
     */
    public function index(Project $project, Request $request)
    {

        if($request->type != null && $request->type != 'all'){
            $material_price_wastages = $project->boqCivilBudgets()->where('budget_type', $request->type)->groupBy('nested_material_id')
                ->with('boqMaterialPriceWastage.nestedMaterial')
                ->get();
        } else {
            $material_price_wastages = $project->boqCivilBudgets()->where('budget_type', '!=','labour')->groupBy('nested_material_id')
                ->with('boqMaterialPriceWastage.nestedMaterial')
                ->get();
        }

        $material_price_wastages = $material_price_wastages->sortBy('boqMaterialPriceWastage.nestedMaterial.name');

        return view('boq.departments.civil.configurations.projectwisematerialprice.index', compact('material_price_wastages', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $nested_materials = NestedMaterial::get()->toTree();

        return view('boq.departments.civil.configurations.materialpricewastage.create', compact('nested_materials', 'project'));
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
            for ($i = 0; $i < count($request->nested_material_id); $i++)
            {
                $obj                      = new BoqMaterialPriceWastage();
                $obj->price               = $request['price'][$i];
                $obj->project_id          = $request->project_id;
                $obj->nested_material_id  = $request['nested_material_id'][$i];
                $obj->is_other_cost       = $request->is_other_cost;
                $obj->other_material_head = $request->other_material_head;
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
    public function edit(Project $project, BoqCivilBudget $projectWiseMaterialPrice)
    {

        $projectWiseMaterialPrice->load('boqMaterialPriceWastage.nestedMaterial');
        $nested_materials = NestedMaterial::get()->toTree();

        return view('boq.departments.civil.configurations.projectwisematerialprice.edit-form', compact('nested_materials', 'projectWiseMaterialPrice', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, BoqCivilBudget $projectWiseMaterialPrice, Request $request)
    {
        try {

            $checkIsInitialBudgetOrNot = BoqCivilRevisedSheet::where('project_id',$request->project_id)->max('escalation_no');

            if($checkIsInitialBudgetOrNot > 0){
                return redirect()->back()->withErrors('You can not update price from here.You have to visit revised sheet for price escalation');
            }

            //update material rate in boq_material_price_wastage table
            $projectWiseMaterialPrice->boqMaterialPriceWastage->update([
                'price' => $request->rate
            ]);

            // update all row rate and total amount column where nested_material_id is same and project_id is same in boqcivilbudget table
            $civil_budget_materials = BoqCivilBudget::where('nested_material_id', $request->nested_material_id)
                ->where('project_id', $request->project_id)
                ->get();

            foreach ($civil_budget_materials as $civil_budget_material)
            {
                $civil_budget_material
                    ->update([
                    'rate' => $request->rate,
                    'total_amount' => $request->rate * $civil_budget_material->total_quantity
                ]);
            }


            // all revised sheet data update
            $civil_revised_sheet_materials = BoqCivilRevisedSheet::where('nested_material_id', $request->nested_material_id)
                ->where('project_id', $request->project_id)
                ->get();

            foreach ($civil_revised_sheet_materials as $civil_revised_sheet_material)
            {
                $civil_revised_sheet_material
                    ->update([
                        'primary_price' => $request->rate,
                        'primary_amount' => $request->rate * $civil_revised_sheet_material->primary_quantity,
                        'price_after_revised' => $request->rate + $civil_revised_sheet_material->revised_qty,
                        'amount_after_revised' => $request->rate * $civil_revised_sheet_material->primary_quantity,
                    ]);
            }


            return redirect()->route('boq.project.departments.civil.configurations.projectwise-material-price.index', $project)
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
