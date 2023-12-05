<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Procurement\NestedMaterial;
use App\Boq\Configurations\BoqFloor;
use App\Http\Controllers\Controller;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\BoqSupremeBudget;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Sanitary\ProjectWiseMaterial;
use App\Boq\Departments\Sanitary\SanitaryMaterialRate;
use App\Boq\Departments\Sanitary\ProjectWiseMaterialDetails;

class ProjectWiseMaterialController extends Controller
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
        if (!empty($secondParentId)){
            $materialRateData = ProjectWiseMaterial::with('NestedMaterial')
            ->whereHas('projectWiseMaterialDetails.material', function ($q) use ($secondParentId){
                $q->where('parent_id', $secondParentId);
            })->where('project_id', $project->id)->latest()->get();
        }elseif (!empty($parentId)){
            $materialRateData = ProjectWiseMaterial::where('project_id', $project->id)->
            whereHas('projectWiseMaterialDetails.material.parent', function ($q) use ($parentId){
                $q->where('parent_id', $parentId);
            })->latest()->get();
        }else{
            $materialRateData = ProjectWiseMaterial::with('projectWiseMaterialDetails.material')
                ->where('project_id', $project->id)->latest()->get();
        }

        if($request->reportType && $request->reportType == 'summery_pdf'){
            return PDF::loadView('boq.departments.sanitary.project-wise-materials.pdf',compact('project', 'request','materialRateData'))->stream($project->name.'\'s_materials.pdf');
        }elseif ($request->reportType && $request->reportType == 'details_pdf'){
            return PDF::loadView('boq.departments.sanitary.project-wise-materials.pdf',compact('project', 'request','materialRateData'))->stream($project->name.'\'s_materials.pdf');
        }else{
            $rateType = ['A'=>'A','B'=>'B','C'=>'C','D'=>'D','F'=>'F','G'=>'G','H'=>'H','I'=>'I'];
            $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
            return view('boq.departments.sanitary.project-wise-materials.index',compact('request','project', 'materialRateData','leyer1NestedMaterial','rateType'));
        }
    }

    public function create(Project $project)
    {
        $formType = 'create';
        $floors = BoqFloorProject::where('project_id', $project->id)->get()->pluck('floor.name','boq_floor_project_id');
        $rateType = ['All'=> 'All', 'Master (LW)'=>'Master (LW)','Master (FC)'=>'Master (FC)','Child (LW)'=>'Child (LW)','Child (FC)'=>'Child (FC)','Common (LW)'=>'Common (LW)','Common (FC)'=>'Common (FC)',
                    'Maid Toilet (LW)'=>'Maid Toilet (LW)','Maid Toilet (FC)'=>'Maid Toilet (FC)','Commercial Toilet'=>'Commercial Toilet'];
                $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('account_id',123)->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        return view('boq.departments.sanitary.project-wise-materials.create', compact('floors','project','rateType','leyer1NestedMaterial','formType'));
    }

    public function projectWiseMaterialRateCreate(Project $project, $parent_id)
    {

        $formType = 'create';
        $floors = BoqFloorProject::where('project_id', $project->id)->get()->pluck('floor.name','boq_floor_project_id');
        $rateType = ['All'=> 'All', 'Master (LW)'=>'Master (LW)','Master (FC)'=>'Master (FC)','Child (LW)'=>'Child (LW)','Child (FC)'=>'Child (FC)','Common (LW)'=>'Common (LW)','Common (FC)'=>'Common (FC)',
            'Maid Toilet (LW)'=>'Maid Toilet (LW)','Maid Toilet (FC)'=>'Maid Toilet (FC)','Commercial Toilet'=>'Commercial Toilet'];
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('account_id',123)->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        $secondParents = NestedMaterial::where('parent_id', $parent_id)->where('account_id',123)->pluck('name','id');
        return view('boq.departments.sanitary.project-wise-materials.create', compact('parent_id','secondParents','floors','project','rateType','leyer1NestedMaterial','formType'));
    }

    public function store(Request $request, Project $project)
    {
        try{
            $request->validate([
                'material_second_id' => 'unique:project_wise_materials,material_second_id',
            ]);
            $data = $request->only('floor_id','material_second_id');
            $data['project_id'] = $project->id;
            $data['user_id'] = auth()->user()->id;
            DB::transaction(function()use($data,$request){
                $materialProjectRates = array();
                foreach($request->quantity as  $key => $materialRate){
                    if (($key > 0) && ($request->material_id[$key] == $request->material_id[$key-1])) {
                        $quantity = $request->quantity[$key] + $request->quantity[$key-1];
                    }else {
                        $quantity = $request->quantity[$key];
                    }
                    if ($request->quantity[$key] != null){
                    $materialProjectRates[] = [
                        'material_id'       =>  $request->material_id[$key],
                        'material_rate'     =>  $request->material_rate[$key],
                        'rate_type'         =>  $request->rate_type[$key],
                        'quantity'          =>  $request->quantity[$key],
                        ];

                    $materialbudgetdetails_data[] = [
                        'budget_for'            =>  "Sanitary",
                        'project_id'            =>  $data['project_id'],
                        'material_id'           =>  $request->material_id[$key],
                        'quantity'              =>  $quantity,
                        'created_at'            =>  now()
                        ];
                    }

                    SanitaryMaterialRate::where('material_id',$request->material_id[$key])->update(['material_rate' =>  $request->material_rate[$key]]);
                };
                $projectMaterial = ProjectWiseMaterial::create($data);
                foreach($materialbudgetdetails_data as $key => $materialbudgetdetails){
                    $model = BoqSupremeBudget::where([['budget_for', "Sanitary"], ['project_id', $data['project_id']], ['material_id', $materialbudgetdetails_data[$key]['material_id']]])->first();

                    if ($model) {
                        $model->update(['quantity' => $materialbudgetdetails_data[$key]['quantity']]);
                    } else {
                        BoqSupremeBudget::insert($materialbudgetdetails_data[$key]);
                    }
                }
                $projectMaterial->projectWiseMaterialDetails()->createMany($materialProjectRates);
            });

            return redirect()->route('boq.project.departments.sanitary.project-wise-materials.index',$project)->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(ProjectWiseMaterial $projectWiseMaterial)
    {
        //
    }

    public function edit($project,$project_wise_material,Request $request)
    {
        $formType = 'edit';
        $calculation = $request->calculation;
        $ProjectWiseMaterialData = ProjectWiseMaterial::findOrFail($project_wise_material);
        $secondLayerMaterial = NestedMaterial::with('descendants')
                                               ->where('account_id',123)
                                               ->where('parent_id',$ProjectWiseMaterialData->NestedMaterial->parent_id)
                                               ->orderBy('id')
                                               ->pluck('name','id');

        $floors = BoqFloorProject::where('project_id', $project)->get()->pluck('floor.name','boq_floor_project_id');
        $rateType = ['All'=> 'All', 'Master (LW)'=>'Master (LW)','Master (FC)'=>'Master (FC)','Child (LW)'=>'Child (LW)','Child (FC)'=>'Child (FC)','Common (LW)'=>'Common (LW)','Common (FC)'=>'Common (FC)',
            'Maid Toilet (LW)'=>'Maid Toilet (LW)','Maid Toilet (FC)'=>'Maid Toilet (FC)','Commercial Toilet'=>'Commercial Toilet'];        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('account_id',123)->where('parent_id',null)->orderBy('id')->pluck('name', 'id');
        return view('boq.departments.sanitary.project-wise-materials.create', compact('project','project_wise_material','calculation','floors','rateType','leyer1NestedMaterial','ProjectWiseMaterialData','secondLayerMaterial','formType'));
    }

    public function update(Request $request, Project $project,ProjectWiseMaterial $projectWiseMaterial)
    {
        try{
            $data = $request->only('floor_id','material_second_id');
            $data['project_id'] = $project->id;
            $data['user_id'] = auth()->user()->id;

            $materialProjectRates = array();
            foreach($request->quantity as  $key => $materialRate){
                if (($key > 0) && ($request->material_id[$key] == $request->material_id[$key-1])) {
                    $quantity = $request->quantity[$key] + $request->quantity[$key-1];
                }else {
                    $quantity = $request->quantity[$key];
                }
                if ($request->quantity[$key] != null){
                $materialProjectRates[] = [
                    'material_id'       =>  $request->material_id[$key],
                    'material_rate'     =>  $request->material_rate[$key],
                    'rate_type'         =>  $request->rate_type[$key],
                    'quantity'          =>  $request->quantity[$key],
                    ];

                $materialbudgetdetails_data[] = [
                    'budget_for'            =>  "Sanitary",
                    'project_id'            =>  $project,
                    'material_id'           =>  $request->material_id[$key],
                    'quantity'              =>  $quantity,
                    'created_at'            =>  now()
                    ];
                }

                SanitaryMaterialRate::where('material_id')->update(['material_rate'     =>  $request->material_rate[$key]]);
            }

            DB::transaction(function()use($data, $materialProjectRates,$projectWiseMaterial, $materialbudgetdetails_data){
                foreach($materialbudgetdetails_data as $key => $materialbudgetdetails){
                    $model = BoqSupremeBudget::where([['budget_for', "Sanitary"], ['project_id', $data['project_id']], ['material_id', $materialbudgetdetails_data[$key]['material_id']]])->first();

                    if ($model) {
                        $model->update(['quantity' => $materialbudgetdetails_data[$key]['quantity']]);
                    }
                }
                $projectWiseMaterial->update($data);
                $projectWiseMaterial->projectWiseMaterialDetails()->delete();
                $projectWiseMaterial->projectWiseMaterialDetails()->createMany($materialProjectRates);
            });

            return redirect()->route('boq.project.departments.sanitary.project-wise-materials.index',$project)->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Project $project,ProjectWiseMaterial $projectWiseMaterial)
    {
        try{
            foreach ($projectWiseMaterial->projectWiseMaterialDetails as $key => $value) {
                BoqSupremeBudget::where([['budget_for', "Sanitary"], ['project_id', $project['id']], ['material_id', $value['material_id']]])->delete();
            }
            $projectWiseMaterial->delete();

            return redirect()->route('boq.project.departments.sanitary.project-wise-materials.index',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function getProjectWiseMaterialDetailsInfo($project_id,$id)
    {
        //
        $data =  ProjectWiseMaterialDetails::with(['projectWiseMaterial.floorProject.floor','projectWiseMaterial.NestedMaterial','material'])
        ->where('id', $id)
        ->get();
        return $data;
    }
    public function UpdateIndividualProjectWiseMaterialDetails($project_id,Request $request)
    {
        try{
            $data = $request->only('material_id','rate_type','material_rate','quantity');
            $project = Project::findOrFail($request->project_id);

            $individualMaterial = ProjectWiseMaterialDetails::findOrFail($request->id);
            SanitaryMaterialRate::where('material_id')->update(['material_rate'     =>  $request->material_rate]);

            $material = BoqSupremeBudget::where([['budget_for', "Sanitary"], ['project_id', $request->project_id], ['material_id', $request->material_id]])->first();
            $quantity = ($material['quantity'] - $individualMaterial['quantity']) + $request->quantity;

            DB::transaction(function()use($data, $individualMaterial, $material, $quantity){
                $individualMaterial->update($data);
                $material->update(['quantity' => $quantity]);
            });
            return redirect()->route('boq.project.departments.sanitary.project-wise-materials.index',$project)->with('success', 'Material Rate has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    public function DeleteIndividualProjectWiseMaterialDetails(Project $project,$ProjectWiseMaterialDetails_id)
    {
        try{
            $individualMaterial = ProjectWiseMaterialDetails::findOrFail($ProjectWiseMaterialDetails_id);
            $material = BoqSupremeBudget::where([['budget_for', "Sanitary"], ['project_id', $project['id']], ['material_id', $individualMaterial['material_id']]])->first();

            $quantity = ($material['quantity'] - $individualMaterial['quantity']);

            $material->update(['quantity' => $quantity]);
            $individualMaterial->delete();
            return redirect()->route('boq.project.departments.sanitary.project-wise-materials.index',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
