<?php

namespace App\Http\Controllers\Boq\Configurations;

use App\Boq\Configurations\BoqFloorType;
use App\Boq\Configurations\BoqFloorTypeBoqWork;
use App\Boq\Configurations\BoqWork;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\BoqFloorTypeWorkEditRequest;
use App\Http\Requests\Boq\BoqFloorTypeWorkRequest;
use Illuminate\Http\Request;

class BoqFloorTypeBoqWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floor_type_works = BoqFloorTypeBoqWork::with('boq_floor_type','boq_work')->paginate(10);

        return view('boq.configurations.workfloortype.index', compact('floor_type_works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $works = BoqWork::get()->toTree();
        $floor_types = BoqFloorType::all();

        return view('boq.configurations.workfloortype.create', compact('works', 'floor_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqFloorTypeWorkRequest $request)
    {
        try {
            $floor = BoqFloorType::find($request->boq_floor_type_id);
            $floor->boqFloorTypeWorks()->createMany($this->makeFloorTypeWorkData($request->all()));

            return redirect()->route('boq.configurations.floor-type-work.index')
                ->withMessage('Floor type work created successfully.');
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
    public function edit(BoqFloorTypeBoqWork $floor_type_work)
    {
        $works            = BoqWork::get()->toTree();
        $floor_types = BoqFloorType::all();

        return view('boq.configurations.workfloortype.edit-form', compact('works', 'floor_types', 'floor_type_work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoqFloorTypeBoqWork $floor_type_work, BoqFloorTypeWorkEditRequest $request)
    {
        try {

            $floor_type_work->update($request->all());

            return redirect()->route('boq.configurations.floor-type-work.index')
                ->withMessage('Floor type work created successfully.');
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
    public function destroy(BoqFloorTypeBoqWork $floor_type_work)
    {
        try {
            $floor_type_work->delete();

            return redirect()->route('boq.configurations.floor-type-work.index')
                ->withMessage('Floor type work deleted successfully.');
        }
        catch (\Exception$e)
        {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    private function makeFloorTypeWorkData(array $request): array
    {
        $boqFloorTypeWorkData = [];

        foreach ($request['boq_work_id'] as $key => $work)
        {
            $boqFloorTypeWorkData[] = [
                'boq_work_id'        => $work,
                'boq_floor_type_id'  => $request['boq_floor_type_id'],
            ];
        }

        return $boqFloorTypeWorkData;
    }
}
