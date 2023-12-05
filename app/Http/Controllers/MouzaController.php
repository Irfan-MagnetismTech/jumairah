<?php

namespace App\Http\Controllers;

use App\District;
use App\Division;
use App\Http\Requests\MouzaRequest;
use App\Mouza;
use App\Thana;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class MouzaController extends Controller
{

    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:mouza-view|mouza-create|mouza-edit|mouza-delete', ['only' => ['index','show']]);
        $this->middleware('permission:mouza-create', ['only' => ['create','store']]);
        $this->middleware('permission:mouza-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:mouza-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mouzas = Mouza::query()->latest()->get();
        return view('mouzas.index',compact('mouzas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $division = Division::pluck('name','id');
        $district = [];
        $thana = [];

        return view('mouzas.create',compact('formType','division','district','thana'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MouzaRequest $request)
    {
        try{
            $data = $request->only('thana_id','name');
            Mouza::create($data);
            return redirect()->route('mouzas.index')->with('message', 'Data has been created successfully');
        }catch(QueryException $err){
            return redirect()->route('mouzas.index')->withErrors($err->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mouza $mouzas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mouza $mouza)
    {
        $formType = 'edit';
        $division = Division::pluck('name','id');
        $district = District::where('division_id',$mouza->thana->district->division->id)->pluck('name','id');
        $thana = Thana::where('district_id',$mouza->thana->district->id)->pluck('name','id');
        return view('mouzas.create',compact('formType','division','district','thana','mouza'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MouzaRequest $request, Mouza $mouza)
    {
        try{
            $data = $request->only('thana_id','name');
            $mouza->update($data);
            return redirect()->route('mouzas.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $err){
            return redirect()->route('mouzas.index')->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mouza $mouza)
    {
        try{
            $mouza->delete();
            return redirect()->route('mouzas.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('mouzas.index')->withErrors($e->getMessage());
        }
    }
}
