<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqMaterialFormula;
use App\Boq\Configurations\BoqWork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqMaterialFormulaEditRequest;
use App\Http\Requests\Boq\BoqMaterialFormulaRequest;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Http\Request;

class BoqMaterialFormulaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-civil', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $material_formulas = BoqMaterialFormula::with('material', 'work')->get();

        return view('boq.departments.civil.configurations.materialformula.index', compact('material_formulas', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();
        $works            = BoqWork::get()->toTree();

        return view('boq.departments.civil.configurations.materialformula.create', compact('nested_materials', 'works', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, BoqMaterialFormulaRequest $request)
    {
        try {
            //$request->merge(['is_multiply_calc_no' => $request->has('is_multiply_calc_no')]);
            $work = BoqWork::find($request->work_id);
            $work->boqMaterialFormulas()->createMany($this->makeMaterialFormulasData($request->all()));

            return redirect()->route('boq.project.departments.civil.configurations.material-formulas.index', $project)
                ->withMessage('Material formula created successfully.');
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
    public function edit(Project $project, BoqMaterialFormula $materialFormula)
    {
        $works            = BoqWork::get()->toTree();
        $nested_materials = NestedMaterial::withDepth()->having('depth', '=', 2)->get();

        return view('boq.departments.civil.configurations.materialformula.edit-form', compact('works', 'nested_materials', 'materialFormula', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, BoqMaterialFormula $materialFormula, BoqMaterialFormulaEditRequest $request)
    {
        try {

            $materialFormula->update($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.material-formulas.index', $project)
                ->withMessage('Material formula updated successfully.');
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
    public function destroy(Project $project, BoqMaterialFormula $materialFormula)
    {
        try {
            $materialFormula->delete();

            return redirect()->route('boq.project.departments.civil.configurations.material-formulas.index', $project)
                ->withMessage('Material formula deleted successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    /**
     * @param array $request
     * @return array
     */
    private function makeMaterialFormulasData(array $request): array
    {
        $materialFormulasData = [];

        foreach ($request['nested_material_id'] as $key => $nested_material)
        {
            $materialFormulasData[] = [
                'nested_material_id' => $nested_material,
                'work_id'            => $request['work_id'],
                'project_id'            => $request['project_id'],
                'percentage_value'   => $request['percentage_value'][$key],
                'wastage'            => $request['wastage'][$key],
            ];
        }

        return $materialFormulasData;
    }
}
