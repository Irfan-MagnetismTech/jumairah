<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\BuildingInfo;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BuidingInfoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('building-show');
        $buildingInfos = BuildingInfo::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::building-info.index', compact('buildingInfos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('building-create');
        $formType = "create";
        return view('hr::building-info.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('building-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                BuildingInfo::where('com_id', auth()->user()->com_id)->create($input);
            });

            return redirect()->route('building-infos.index')->with('message', 'Building information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('building-infos.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('building-edit');
        $formType = "edit";
        $buildingInfo = BuildingInfo::where('com_id', auth()->user()->com_id)->findOrFail($id);
        return view('hr::building-info.create', compact('formType', 'buildingInfo'));
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
            $this->authorize('building-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $buildingInfo = BuildingInfo::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
                $buildingInfo->update($input);
            });

            return redirect()->route('building-infos.index')->with('message', 'Building information updated successfully.');
        } catch (QueryException $e) {
            return $e->getMessage();
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
                $this->authorize('building-delete');
                $message = 0;
                DB::transaction(function () use ($id, &$message) {
                    $buildingInfo = BuildingInfo::with('floors')->where('com_id', auth()->user()->com_id)->where('id',$id)->first();
                    // dd($buildingInfo);
                    if ($buildingInfo->floors->count() === 0) {
                        $buildingInfo->delete();
                        $message = ['message'=>'Building information deleted successfully.'];
                    } else {
                        $message = ['error'=>'This data has some dependency.'];
                    }
                });

                return redirect()->route('building-infos.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('building-infos.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
