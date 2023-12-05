<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\SanitaryFormula;
use App\Http\Controllers\Controller;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SanitaryFormulaDetail;

class SanitaryFormulaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    public function index(Project $project)
    {
        //
        $SanitaryFormulaDatas = SanitaryFormula::with('sanitaryFormulaDetails')->get();
        return view('boq.departments.sanitary.sanitary-formulas.index', compact('SanitaryFormulaDatas', 'project'));
    }

    public function create(Project $project)
    {
        $formType = 'create';
        $locationTypes = ['Master Bath' => 'Master Bath','Child Bath' => 'Child Bath','Common Bath' => 'Common Bath',
                        'S. Toilet Bath' => 'S. Toilet Bath','Kitchen' => 'Kitchen','Common (R)' => 'Common (R)','Toilet' => 'Toilet','Wash Basin' => 'Wash Basin',
                        'Urinal' => 'Urinal','Pantry' => 'Pantry','Common (C)' => 'Common (C)'];
        return view('boq.departments.sanitary.sanitary-formulas.create', compact('locationTypes','project','formType'));
    }

    public function store(Request $request, Project $project)
    {
        try{
            $data = $request->only('location_type','location_for');
            $detailArray = array();
            foreach($request->material_id as  $key => $detail){
                $detailArray[] = [
                    'material_id'      =>  $request->material_id[$key],
                    'multiply_qnt'     =>  $request->multiply_qnt[$key],
                    'additional_qnt'   =>  $request->additional_qnt[$key],
                    'formula'          =>  $request->formula[$key],
                ];
            }

            DB::transaction(function()use($data, $detailArray){
                $formula = SanitaryFormula::create($data);
                $formula->sanitaryFormulaDetails()->createMany($detailArray);
            });

            return redirect()->route('boq.project.departments.sanitary.sanitary-formulas.index',$project)->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(SanitaryFormula $sanitaryFormula)
    {
        //
    }

    public function edit(Project $project,SanitaryFormula $sanitaryFormula)
    {
        $formType = 'edit';
        $locationTypes = ['Master Bath' => 'Master Bath','Child Bath' => 'Child Bath','Common Bath' => 'Common Bath',
            'S. Toilet Bath' => 'S. Toilet Bath','Kitchen' => 'Kitchen','Common (R)' => 'Common (R)','Toilet' => 'Toilet','Wash Basin' => 'Wash Basin',
            'Urinal' => 'Urinal','Pantry' => 'Pantry','Common (C)' => 'Common (C)'];
        return view('boq.departments.sanitary.sanitary-formulas.create', compact('locationTypes','project','formType','sanitaryFormula'));
    }


    public function update(Request $request,Project $project, SanitaryFormula $sanitaryFormula)
    {
        //
        try{

            // $detailArray = array();
            // foreach($request->material_id as  $key => $detail){
            //     $detailArray = [
            //         'material_id'      =>  $request->material_id[$key],
            //         'multiply_qnt'     =>  $request->multiply_qnt[$key],
            //         'additional_qnt'   =>  $request->additional_qnt[$key],
            //         'formula'          =>  $request->formula[$key],
            //     ];
            // }
            // DB::transaction(function()use($detailArray,$sanitaryFormula,$request){
            //     $formula = SanitaryFormula::firstOrCreate(
            //                         ['location_type' =>  $request->location_type,
            //                         'location_for' => $request->location_for]
            //     );
            //     $detailArray['sanitary_formula_id'] = $formula->id;
            //     $sanitaryFormula->update($detailArray);
            // });

            $data = $request->only('location_type','location_for');

            $detailArray = array();
            foreach($request->material_id as  $key => $detail){
                $detailArray[] = [
                    'material_id'      =>  $request->material_id[$key],
                    'multiply_qnt'     =>  $request->multiply_qnt[$key],
                    'additional_qnt'   =>  $request->additional_qnt[$key],
                    'formula'          =>  $request->formula[$key],
                ];
            }
            DB::transaction(function()use($detailArray,$sanitaryFormula,$request,$data){
                $sanitaryFormula->update($data);
                $sanitaryFormula->sanitaryFormulaDetails()->delete();
                $sanitaryFormula->sanitaryFormulaDetails()->createMany($detailArray);
            });

            return redirect()->route('boq.project.departments.sanitary.sanitary-formulas.index',$project)->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanitaryFormula  $sanitaryFormula
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,SanitaryFormula $sanitaryFormula)
    {
        try{
            $sanitaryFormula->delete();
            return redirect()->route('boq.project.departments.sanitary.sanitary-formulas.index',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function getSanitaryFormulaDetailsInfo($project_id,$id)
    {
        //
        $data =  SanitaryFormulaDetail::with(['material.unit'])
        ->where('id', $id)
        ->get();
        return $data;
    }

    public function UpdateIndividualSanitaryFormulaDetails($project_id,Request $request)
    {
        try{
            $data = $request->only('material_id','multiply_qnt','additional_qnt','formula');

            $individualFormula = SanitaryFormulaDetail::findOrFail($request->id);
            DB::transaction(function()use($data, $individualFormula){
                $individualFormula->update($data);
            });
            $project = Project::findOrFail($request->project_id);
            return redirect()->route('boq.project.departments.sanitary.sanitary-formulas.index',$project)->with('success', 'Formula has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function DeleteIndividualSanitaryFormulaDetails(Project $project,$SaniteryFormulaDetails_id)
    {
        try{
            $individualMaterial = SanitaryFormulaDetail::findOrFail($SaniteryFormulaDetails_id);
            $individualMaterial->delete();
            return redirect()->route('boq.project.departments.sanitary.sanitary-formulas.index',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
