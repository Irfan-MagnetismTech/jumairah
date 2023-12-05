<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingRequest;
use App\Parking;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:parking-view|parking-create|parking-edit|parking-delete', ['only' => ['index','show']]);
        $this->middleware('permission:parking-create', ['only' => ['create','store']]);
        $this->middleware('permission:parking-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:parking-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $parkings=Parking::with('parkingDetails')->latest()->get();
        return view('parkings.index', compact('parkings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $levels = [];
        $locations = [];
        $faces = ['East','West','North','South','North-East','North-West','South-West','South-East'];
//        $parking = '';
        return view('parkings.create', compact('formType', 'faces', 'levels', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParkingRequest $request)
    {
//        dd($request->all());
        try{
            $parkingData = $request->only('project_id', 'location', 'level', 'total_parking');
            DB::transaction(function()use($parkingData){
                $parking = Parking::create($parkingData);
                $parking->parkingDetails()->createMany(
                    collect(request()->parking_name)->map(function($item, $key)use($parking){
                        return [
                            'parking_name'=>request()->parking_name[$key],
                            'parking_owner'=>request()->parking_owner[$key],
                            'parking_composite'=>$parking->id.request()->parking_name[$key],
                        ];
                    })->toArray()
                );
            });
            return redirect()->route('parkings.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function show(Parking $parking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function edit(Parking $parking)
    {
        $formType = "edit";
        $locations = $parking->project->basement > 0 ? ['Ground'=>'Ground', 'Basement' => 'Basement'] : ['Ground' => 'Ground'];
        $levels = [];
        $faces = ['East','West','North','South','North-East','North-West','South-West','South-East'];
        return view('parkings.create', compact('formType', 'faces', 'levels', 'parking', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function update(ParkingRequest $request, Parking $parking)
    {
        try{
            $parkingData = $request->only('project_id', 'location', 'level', 'total_parking');
            DB::transaction(function()use($parking, $parkingData){
                $parking->update($parkingData);
                $parking->parkingDetails()->delete();
                $parking->parkingDetails()->createMany(
                    collect(request()->parking_name)->map(function($item, $key)use($parking){
                        return [
                            'parking_name'=>request()->parking_name[$key],
                            'parking_owner'=>request()->parking_owner[$key],
                            'parking_composite'=>$parking->id.request()->parking_name[$key],
                        ];
                    })->toArray()
                );
            });
            return redirect()->route('parkings.index')->with('message', 'Data has been updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parking  $parking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parking $parking)
    {
        try{
            $parking->delete();
            return redirect()->route('parkings.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
