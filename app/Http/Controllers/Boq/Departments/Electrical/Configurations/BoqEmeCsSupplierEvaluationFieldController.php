<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Configurations;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\BoqEmeCsSupplierEvalField;

class BoqEmeCsSupplierEvaluationFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $permissions = BoqEmeCsSupplierEvalField::latest()->get();
        $formType = "create";
        return view('boq.departments.electrical.cs-supplier-option.create', compact('permissions', 'formType','project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $permissions = BoqEmeCsSupplierEvalField::latest()->get();
        $formType = "create";
        return view('boq.departments.electrical.cs-supplier-option.create', compact('permissions', 'formType','project'));
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
            $this->validate($request,
                [
                    'name' => 'required|unique:boq_eme_cs_supplier_eval_fields,name',
                ]
            );
            $data = $request->all();
            BoqEmeCsSupplierEvalField::create($data);
            return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project,BoqEmeCsSupplierEvalField $cs_supplier_eval_option)
    {
        $formType = "edit";
        $permissions = BoqEmeCsSupplierEvalField::latest()->get();
        return view('boq.departments.electrical.cs-supplier-option.create', compact('permissions', 'formType','project','cs_supplier_eval_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Project $project,BoqEmeCsSupplierEvalField $cs_supplier_eval_option)
    {
       try{
        $validatedData = $this->validate($request,
                [
                    'name' => "required|unique:boq_eme_cs_supplier_eval_fields,name,$cs_supplier_eval_option->id",
                ]
            );
        $cs_supplier_eval_option->update($validatedData );
        return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->with('message', 'Data has been updated successfully');
    }catch(QueryException $e){
        return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->withInput()->withErrors($e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project,BoqEmeCsSupplierEvalField $cs_supplier_eval_option)
    {
        try{
            $cs_supplier_eval_option->delete();
            return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create',['project' => $project])->withInput()->withErrors($e->getMessage());
        }
    }
}
