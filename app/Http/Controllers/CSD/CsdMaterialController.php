<?php

namespace App\Http\Controllers\CSD;

use App\CSD\CsdMaterial;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSD\CsdMaterialRequest;
use App\Procurement\Unit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsdMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:csd-material-view|csd-material-create|csd-material-edit|csd-material-delete', ['only' => ['index','show']]);
        $this->middleware('permission:csd-material-create', ['only' => ['create','store']]);
        $this->middleware('permission:csd-material-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:csd-material-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = CsdMaterial::latest()->get();
        return view('csd.material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $materials = CsdMaterial::orderBy('name')->pluck('name', 'id');
        $units = Unit::orderBy('name')->pluck('name', 'id');
        return view('csd.material.create', compact('formType', 'materials', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsdMaterialRequest $request)
    {
        try{
            $material_data = $request->only('name','parent_id','unit_id','model');

            DB::transaction(function()use($material_data){
                $material = CsdMaterial::create($material_data);
            });

            return redirect()->route('csd.materials.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CsdMaterial $material)
    {
        $material = CsdMaterial::where('id', $material->id)->firstOrFail();
        return view('csd.material.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CsdMaterial $material)
    {
        $formType = "edit";
        $units = Unit::orderBy('name')->pluck('name', 'id');
        $materials = CsdMaterial::orderBy('name')->pluck('name', 'id');
        $material = CsdMaterial::where('id', $material->id)->first();

        return view('csd.material.create', compact('material', 'materials', 'formType',  'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CsdMaterialRequest $request, CsdMaterial $material)
    {
        
        try{
            $material_data = $request->only('name','parent_id','unit_id','model');

            DB::transaction(function()use($material,$material_data){
                $material->update($material_data);
            });

            return redirect()->route('csd.materials.index')->with('message', 'Data has been updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CsdMaterial $material)
    {
        try{
            $material->delete();
            return redirect()->route('csd.materials.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('csd.materials.create')->withErrors($e->getMessage());
        }
    }
}
