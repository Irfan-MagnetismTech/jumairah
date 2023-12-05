<?php

namespace App\Http\Controllers\Boq\Departments\Civil;

use App\Project;
use App\Procurement\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BoqCivilMaterialSpecificationRequest;
use App\Boq\Departments\Civil\BoqCivilMaterialSpecification;
use App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification;

class BoqCivilMaterialSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $boqCivilMaterialSpecifications = BoqCivilMaterialSpecification::where('project_id', $project->id)->with('unit')->orderBy('item_head')->get()->groupBy('item_head');
        return view('boq.departments.civil.material-specifications.index', compact('project', 'boqCivilMaterialSpecifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $units = Unit::latest()->get();
        $boqCivilMaterialSpecifications = null;
        $globalMaterialSpecifications = BoqCivilGlobalMaterialSpecification::with('unit')->orderBy('item_head')->get()->groupBy('item_head');

        return view('boq.departments.civil.material-specifications.create', compact('project', 'units', 'globalMaterialSpecifications', 'boqCivilMaterialSpecifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, BoqCivilMaterialSpecificationRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $insertedData = [];
            foreach ($data['item_name'] as $key => $value) {
                $insertedData[] = [
                    'item_head' => $data['item_head'],
                    'project_id' => $project->id,
                    'item_name' => $value,
                    'unit_id' => $data['unit_id'][$key],
                    'specification' => $data['specification'][$key],
                    'unit_price' => $data['unit_price'][$key],
                    'remarks' => $data['remarks'][$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            BoqCivilMaterialSpecification::insert($insertedData);
            DB::commit();

            return redirect()->route('boq.project.material-specifications.index', $project)
                ->withMessage('Material specificaition created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BoqCivilMaterialSpecification  $boqCivilMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function show(BoqCivilMaterialSpecification $boqCivilMaterialSpecification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BoqCivilMaterialSpecification  $boqCivilMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function editmatSpecItemHead(Request $request, Project $project)
    {
        $boqCivilMaterialSpecifications = BoqCivilMaterialSpecification::where('project_id', $project->id)->where('item_head', $request->materialSpecificationItemHead)->with('unit')->get();
        $globalMaterialSpecifications = BoqCivilGlobalMaterialSpecification::with('unit')->orderBy('item_head')->get()->groupBy('item_head');
        $units = Unit::all();

        return view('boq.departments.civil.material-specifications.edit', compact('boqCivilMaterialSpecifications', 'units', 'project', 'globalMaterialSpecifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BoqCivilMaterialSpecification  $boqCivilMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function updatematSpecItemHead(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $updatedData = [];
            foreach ($data['item_name'] as $key => $value) {
                $updatedData[] = [
                    'item_head' => $request->materialSpecificationItemHead,
                    'project_id' => $project->id,
                    'item_name' => $value,
                    'unit_id' => $data['unit_id'][$key],
                    'specification' => $data['specification'][$key],
                    'unit_price' => $data['unit_price'][$key],
                    'remarks' => $data['remarks'][$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            BoqCivilMaterialSpecification::where('project_id', $project->id)->where('item_head', $request->materialSpecificationItemHead)->delete();
            BoqCivilMaterialSpecification::insert($updatedData);
            DB::commit();

            return redirect()->route('boq.project.material-specifications.index', $request->project)
                ->withMessage('Material specificaition updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BoqCivilMaterialSpecification  $boqCivilMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function deletematSpecItemHead(Request $request)
    {
        try {
            DB::beginTransaction();
            BoqCivilMaterialSpecification::where('project_id', $request->project)->where('item_head', $request->materialSpecificationItemHead)->delete();
            DB::commit();


            return redirect()->route('boq.project.material-specifications.index', $request->project)
                ->withMessage('Material specificaition deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
