<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\AdjustmentType;
use Illuminate\Contracts\Support\Renderable;

class AdjustmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $adjustmentTypes = AdjustmentType::orderBy('id', 'desc')->get();
        return view('hr::adjustment-types.index', compact('adjustmentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = 'create';
        return view('hr::adjustment-types.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        try {
            $input = $request->only('name', 'type');
            AdjustmentType::create($input);
            return redirect()->route('adjustment-types.index')->with('success', 'Adjustment Type created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('adjustment-types.index')->with('error', 'Error! ' . $e->getMessage());
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
        $formType = 'edit';
        $adjustmentType = AdjustmentType::find($id);
        return view('hr::adjustment-types.create', compact('formType', 'adjustmentType'));
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
            $input = $request->only('name', 'type');
            AdjustmentType::where('id', $id)->update($input);
            return redirect()->route('adjustment-types.index')->with('success', 'Adjustment Type updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('adjustment-types.index')->with('error', 'Error! ' . $e->getMessage());
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
            AdjustmentType::where('id', $id)->delete();
            return redirect()->route('adjustment-types.index')->with('success', 'Adjustment Type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('adjustment-types.index')->with('error', 'Error! ' . $e->getMessage());
        }
    }
}
