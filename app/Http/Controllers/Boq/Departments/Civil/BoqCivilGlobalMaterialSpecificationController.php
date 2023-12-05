<?php

namespace App\Http\Controllers\Boq\Departments\Civil;

use App\Project;
use App\Procurement\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BoqCivilMaterialSpecificationRequest;
use App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification;

class BoqCivilGlobalMaterialSpecificationController extends Controller
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
        $boqCivilMaterialSpecifications = BoqCivilGlobalMaterialSpecification::with('unit')->orderBy('item_head')->get()->groupBy('item_head');

        return view('boq.departments.civil.global-material-specifications.index', compact('project', 'boqCivilMaterialSpecifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $units = Unit::latest()->get();
        return view('boq.departments.civil.global-material-specifications.create', compact('project', 'units'));
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
                    'item_name' => $value,
                    'unit_id' => $data['unit_id'][$key],
                    'specification' => $data['specification'][$key],
                    'unit_price' => $data['unit_price'][$key],
                    'remarks' => $data['remarks'][$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            BoqCivilGlobalMaterialSpecification::insert($insertedData);
            DB::commit();

            return redirect()->route('boq.project.global-material-specifications.index', $project)
                ->withMessage('Global Material specificaition created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification  $boqCivilGlobalMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function show(BoqCivilGlobalMaterialSpecification $boqCivilGlobalMaterialSpecification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification  $boqCivilGlobalMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function editglobalmatSpecItemHead(Request $request, Project $project)
    {
        $boqCivilMaterialSpecifications = BoqCivilGlobalMaterialSpecification::where('item_head', $request->materialSpecificationItemHead)->with('unit')->get();
        $units = Unit::all();

        return view('boq.departments.civil.global-material-specifications.edit', compact('boqCivilMaterialSpecifications', 'units', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification  $boqCivilGlobalMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function updateglobalmatSpecItemHead(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            $updatedData = [];
            foreach ($data['item_name'] as $key => $value) {
                $updatedData[] = [
                    'item_head' => $data['item_head'],
                    'item_name' => $value,
                    'unit_id' => $data['unit_id'][$key],
                    'specification' => $data['specification'][$key],
                    'unit_price' => $data['unit_price'][$key],
                    'remarks' => $data['remarks'][$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            BoqCivilGlobalMaterialSpecification::where('item_head', $request->materialSpecificationItemHead)->delete();
            BoqCivilGlobalMaterialSpecification::insert($updatedData);
            DB::commit();

            return redirect()->route('boq.project.global-material-specifications.index', $request->project)
                ->withMessage('Global Material specificaition updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecification  $boqCivilGlobalMaterialSpecification
     * @return \Illuminate\Http\Response
     */
    public function deleteglobalmatSpecItemHead(Request $request)
    {
        try {
            DB::beginTransaction();
            BoqCivilGlobalMaterialSpecification::where('item_head', $request->materialSpecificationItemHead)->delete();
            DB::commit();

            return redirect()->route('boq.project.global-material-specifications.index', $request->project)
                ->withMessage('Global Material specificaition deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
