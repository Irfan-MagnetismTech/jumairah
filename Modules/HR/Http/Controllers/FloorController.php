<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Floor;
use Modules\HR\Entities\BuildingInfo;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FloorController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('floor-show');
        $floors = Floor::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::floor.index', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('floor-create');
        $formType = 'create';
        $buildingInfos = BuildingInfo::where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        return view('hr::floor.create', compact('formType','buildingInfos'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $this->authorize('floor-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Floor::create($input);
            });

            return redirect()->route('floors.index')->with('message', 'Floor created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('floor-edit');
        $formType = 'edit';
        $floor = Floor::with('buildingInfo')->where('id',$id)->where('com_id', auth()->user()->com_id)->first();
        $buildingInfos = BuildingInfo::where('id',$id)->where('com_id', auth()->user()->com_id)->orderBy('name')->pluck('name', 'id');
        return view('hr::floor.create', compact('formType','buildingInfos', 'floor'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            $this->authorize('floor-edit');
            $input = $request->all();
            // dd($input);
            DB::transaction(function () use ($input, $request, $id) {
                $floor = Floor::where('id',$id)->where('com_id', auth()->user()->com_id)->first();
                $floor->update($input);
            });

            return redirect()->route('floors.index')->with('message', 'Floor updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        try {
            $this->authorize('floor-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $floor = Floor::with('employees')->where('id',$id)->where('com_id', auth()->user()->com_id)->first();
                // dd($floor);
                if ($floor->employees->count() === 0) {
                    $floor->delete();
                    $message = ['message'=>'Floor deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('floors.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('floors.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
