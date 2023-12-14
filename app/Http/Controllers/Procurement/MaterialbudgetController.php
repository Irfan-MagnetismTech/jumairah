<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;

use App\Http\Requests\MaterialbudgetRequest;
use App\Procurement\BoqSupremeBudget;
use App\Procurement\Materialbudget;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Database\QueryException;  

class MaterialbudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boq_supreme_budget_data = BoqSupremeBudget::orderBy('id', 'desc')->get();
        $groupBy_project_id = $boq_supreme_budget_data->groupBy('project_id')->all();
        return view('procurement.materialbudgets.index', compact('groupBy_project_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $projects = Project::orderBy('name')->pluck('name','id');
        return view('procurement.materialbudgets.create', compact('formType', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialbudgetRequest $request)
    {
        try{
            $materialbudgetdetails_data = array();
            foreach($request->material_id as  $key => $data){
                $materialbudgetdetails_data[] = [
                    'budget_for'    =>  $request->budget_for,
                    'project_id'    =>  $request->project_id,
                    'floor_id'      =>  $request->floor_id[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'      =>  $request->remarks[$key]
                ];
            }
                BoqSupremeBudget::insert($materialbudgetdetails_data);
                return redirect()->route('materialbudgets.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materialbudget  $materialbudget
     * @return \Illuminate\Http\Response
     */
    public function show(BoqSupremeBudget $BoqSupremeBudget)
    {
        dd($BoqSupremeBudget);
        $materials = Materialbudget::where('project_id', $materialbudget->project_id)->get();
        $projects = Project::orderBy('name')->pluck('name','id');
        $categories = NestedMaterial::where('parent_id', null)->orderBy('name')->pluck('name','id');
        return view('procurement.materialbudgets.show', compact('projects','categories', 'materialbudget', 'materials'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materialbudget  $materialbudget
     * @return \Illuminate\Http\Response
     */
    public function edit(Materialbudget $materialbudget)
    {
        $materials = Materialbudget::where('project_id', $materialbudget->project_id)->get();
        $formType = "edit";
        $projects = Project::orderBy('name')->pluck('name','id');
        $categories = NestedMaterial::where('parent_id', null)->orderBy('name')->pluck('name','id');
        return view('procurement.materialbudgets.create', compact('formType', 'projects','categories', 'materialbudget', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materialbudget  $materialbudget
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialbudgetRequest $request, BoqSupremeBudget $BoqSupremeBudget)
    {
        try{
            BoqSupremeBudget::where('project_id', $BoqSupremeBudget->project_id)->delete($BoqSupremeBudget);
            $materialbudgetdetails_data = array();
            foreach($request->material_id as  $key => $data){
                $materialbudgetdetails_data[] = [
                    'budget_for'    =>  $request->budget_for,
                    'project_id'    =>  $request->project_id,
                    'floor_id'      =>  $request->floor_id[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key]
                ];
            }
            BoqSupremeBudget::insert($materialbudgetdetails_data);
            return redirect()->route('materialbudgets.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materialbudget  $materialbudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materialbudget $materialbudget)
    {
        try{
            $materialbudget->delete();
            return redirect()->route('materialbudgets.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('materialbudgets.index')->withErrors($e->getMessage());
        }
    }
}
