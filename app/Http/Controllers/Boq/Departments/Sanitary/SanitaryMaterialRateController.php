<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\SanitaryMaterialRate;
use App\Http\Controllers\Controller;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanitaryMaterialRateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    public function index(Project $project)
    {
        $request = request();
        $parentId = request()->parent_id;
        $secondParentId = request()->parent_id_second;
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('account_id', 123)->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        $parentMaterials = NestedMaterial::whereNull('parent_id')->where('account_id', 123)->pluck('id', 'id');
        if (!empty($secondParentId)){
            $materials = NestedMaterial::whereIn('parent_id', $parentMaterials)->whereHas('descendants.sanitaryMaterialRates')
                ->where('id', $secondParentId)->get()
                ->filter(function ($item){
                    $item['sanitaryMaterials'] = $item->descendants->flatten()->pluck('sanitaryMaterialRates');
                    return $item;
                });
        }else{
            $materials = NestedMaterial::whereIn('parent_id', $parentMaterials)->whereHas('descendants.sanitaryMaterialRates')->get()
                ->filter(function ($item){
                    $item['sanitaryMaterials'] = $item->descendants->flatten()->pluck('sanitaryMaterialRates');
                    return $item;
                });
        }

        return view('boq.departments.sanitary.material-rates.index',compact('request','project', 'materials','leyer1NestedMaterial'));
    }

    public function create(Project $project)
    {
        $rateType = ['A'=>'A','B'=>'B','C'=>'C','D'=>'D','F'=>'F','G'=>'G','H'=>'H','I'=>'I'];
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('account_id',123)->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        $projectData = Project::where('id', session()->get('project_id'))->first();
        return view('boq.departments.sanitary.material-rates.create', compact('project','rateType','projectData','leyer1NestedMaterial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        try{
            $project = session()->get('project_id');
            $RateData = array();
            foreach($request->material_id as  $key => $data){
                $RateData[] = [
                    'material_id'       =>  $request->material_id[$key],
                    'material_rate'     =>  $request->material_rate[$key],
                    'created_at'        =>  now(),
                ];
            }
            DB::transaction(function()use($RateData){
                SanitaryMaterialRate::insert($RateData);
            });
            return redirect()->route('boq.project.departments.sanitary.material-rates.index',$project)->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanitaryMaterialRate  $sanitaryMaterialRate
     * @return \Illuminate\Http\Response
     */
    public function show(SanitaryMaterialRate $sanitaryMaterialRate, Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanitaryMaterialRate  $sanitaryMaterialRate
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, SanitaryMaterialRate $materialRate)
    {
        $sanitaryMaterialRate = $materialRate;
        return view('boq.departments.sanitary.material-rates.edit', compact('project','sanitaryMaterialRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanitaryMaterialRate  $sanitaryMaterialRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $materialRate)
{
    try {
        $rateData = [
            // 'material_id' => $request->input('material_id'),
            'material_rate' => $request->input('material_rate'),
            'updated_at' => now(),
        ];

        $projectId = session()->get('project_id');
        $rateId = SanitaryMaterialRate::findOrFail($request->id);
        // dd($rateId);

        DB::transaction(function () use ($rateId, $rateData) {
            $rateId->update($rateData);
        });

        return redirect()->route('boq.project.departments.sanitary.material-rates.index', ['project' => $projectId])
            ->with('success', 'Rate has been updated successfully');
    } catch (QueryException $e) {
        return redirect()->back()->withInput()->withErrors($e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanitaryMaterialRate  $sanitaryMaterialRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, SanitaryMaterialRate $materialRate)
{
    try {
        $materialRate->delete();
        $projectId = $project;

        return redirect()
            ->route('boq.project.departments.sanitary.material-rates.index', ['project' => $projectId])
            ->with('message', 'Data has been deleted successfully');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->withErrors($e->getMessage());
    }
}
}
