<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqWorkRequest;
use App\Procurement\Unit;
use App\Project;
use Illuminate\Http\Request;

class BoqWorkController extends Controller
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
        $works = BoqWork::with(['materialUnit', 'labourUnit', 'materialLabourUnit'])->get();

        return view('boq.departments.civil.configurations.work.index', compact('works', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $works = BoqWork::get()->toTree();
        $units = Unit::all();

        return view('boq.departments.civil.configurations.work.create', compact('works', 'units', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqWorkRequest $request, Project $project)
    {
        //dd($request->all());
        try
        {
//            if ($request->material_unit === null && $request->labour_unit === null && $request->material_labour_unit === null)
//            {
//                throw new \Exception('Please select at least one unit');
//            }

            $request->merge(['is_reinforcement' => $request->has('is_reinforcement')]);
            //$request->merge(['is_multiply_calc_no' => $request->has('is_multiply_calc_no')]);

            BoqWork::create($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.works.create', compact('project'))
                ->withMessage('Work created successfully.');
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
    public function edit(Project $project, BoqWork $work)
    {
        $works = BoqWork::get()->except($work->id)->toTree();
        $units = Unit::all();

        return view('boq.departments.civil.configurations.work.edit', compact('works', 'units', 'work', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Project $project, BoqWork $work, BoqWorkRequest $request)
    {
        try
        {
//            if ($request->material_unit === null && $request->labour_unit === null && $request->material_labour_unit === null)
//            {
//                throw new \Exception('Please select at least one unit');
//            }

            $request->merge(['is_reinforcement' => $request->has('is_reinforcement')]);
            //$request->merge(['is_multiply_calc_no' => $request->has('is_multiply_calc_no')]);

            $work->update($request->all());

            return redirect()->route('boq.project.departments.civil.configurations.works.index', compact('project'))
                ->withMessage('Work updated successfully.');
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
    public function destroy(Project $project, BoqWork $work)
    {
        try {
            $work->delete();

            return redirect()->route('boq.project.departments.civil.configurations.works.index', ['project' => $project])
                ->withMessage('Work deleted successfully.');
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
     * @param Request $request
     * @return mixed
     */
    public function getBoqWorksByWorkId(Request $request)
    {
        try {
            $boq_works = BoqWork::where('id', $request->work_id)
                ->with(['materialUnit', 'boqWorkUnit', 'labourUnit', 'materialLabourUnit', 'children','boqMaterialFormulas.material.materialPriceWastage', 'boqMaterialFormulas.civilBudget'])
                ->first();

            // add another object with boq_works boq_material_formulas
            $boq_works['additional_materials'] = BoqCivilBudget::where('boq_work_id', $request->work_id)
                ->where('project_id', $request->project_id)
                ->where('budget_type', $request->budget_type)
                ->where('boq_floor_id', $request->boq_floor_id)
                ->where('is_additional_material', 1)
                ->with(['nestedMaterial'])
                ->get();

            return $boq_works;
        }
        catch (\Exception$e)
        {
            return response()->json($e->getMessage());
        }

    }

    /**
     * Get sub works by work id.
     *
     * @param Request $request
     * @return mixed
     */
    public function getBoqSubWorksByWorkId(Request $request)
    {
        $boq_sub_works = BoqWork::with(['materialUnit', 'labourUnit', 'materialLabourUnit','boqMaterialFormulas.material'])
            ->where('parent_id', $request->work_id)
            ->get();

        return $boq_sub_works;
    }
}
