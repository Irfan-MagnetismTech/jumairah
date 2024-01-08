<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Configurations;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\EmeLaborHead;
use App\Http\Requests\EmeLaborHeadRequest;

class EmeLaborHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $formType = "create";
        $laborHeadData = EmeLaborHead::latest()->get();
        return view('boq.departments.electrical.configurations.labor-head.create', compact('project', 'formType', 'laborHeadData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmeLaborHeadRequest $request, Project $project)
    {
        try{
            $laborHeadData = $request->only('name');
            $laborHeadData['user_id'] = auth()->user()->id;

            DB::transaction(function()use($laborHeadData){
                EmeLaborHead::create($laborHeadData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.eme-labor-head.create',$project)->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
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
    public function edit(Project $project, EmeLaborHead $eme_labor_head)
    {
        $formType = "edit";
        $laborHead = EmeLaborHead::where('id', $eme_labor_head->id)->first();
        $laborHeadData = EmeLaborHead::latest()->get();
        return view('boq.departments.electrical.configurations.labor-head.create', compact('project', 'formType', 'laborHead', 'laborHeadData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmeLaborHeadRequest $request, Project $project, EmeLaborHead $eme_labor_head)
    {
        try{
            $laborHeadData = $request->only('name');
            $laborHeadData['user_id'] = auth()->user()->id;
            $laborHead = EmeLaborHead::where('id', $eme_labor_head->id)->first();

            DB::transaction(function()use($laborHeadData, $laborHead){
                $laborHead->update($laborHeadData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.eme-labor-head.create',$project)->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, EmeLaborHead $eme_labor_head)
    {
        try{
            $laborHead =  EmeLaborHead::findOrFail($eme_labor_head->id);
            $laborHead->delete();
            return redirect()->route('boq.project.departments.electrical.configurations.eme-labor-head.create',$project)->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('boq.project.departments.electrical.configurations.eme-labor-head.create',$project)->withErrors($e->getMessage());
        }
    }
}
