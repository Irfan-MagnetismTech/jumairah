<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Configurations\BoqFloorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqFloorRequest;
use Illuminate\Http\Request;

class BoqFloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = BoqFloor::paginate(10);

        return view('boq.configurations.floor.index', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $floors      = BoqFloor::get()->toTree();
        $floor_types = BoqFloorType::all();

        return view('boq.configurations.floor.create', compact('floors', 'floor_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqFloorRequest $request)
    {
        try {
            BoqFloor::create($request->all());

            return redirect()->route('boq.configurations.floors.index')
                ->withMessage('Floor created successfully.');
        }
        catch (\Exception$e)
        {
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
    public function edit(BoqFloor $floor)
    {
        $floors      = BoqFloor::get()->except($floor->id)->toTree();
        $floor_types = BoqFloorType::all();

        return view('boq.configurations.floor.edit', compact('floor_types', 'floor', 'floors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoqFloor $floor, BoqFloorRequest $request)
    {
        try {
            $floor->update($request->all());

            return redirect()->route('boq.configurations.floors.index')
                ->withMessage('Floor updated successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoqFloor $floor)
    {
        try {
            $floor->delete();

            return redirect()->route('boq.configurations.floors.index')
                ->withMessage('Floor deleted successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }
}
