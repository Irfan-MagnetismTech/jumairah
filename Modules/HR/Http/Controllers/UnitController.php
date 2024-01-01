<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Unit;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnitController extends Controller
{
    use AuthorizesRequests;

    function __construct()
    {
        $this->middleware('permission:unit-view|unit-create|unit-edit|unit-delete', ['only' => ['index','show', 'getmaterialmovementsPdf', 'movmentOutApproval']]);
        $this->middleware('permission:unit-create', ['only' => ['create','store']]);
        $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('unit-show');
        $units = Unit::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('unit-create');
        $formType = 'create';
        return view('hr::unit.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('unit-create');
        try {
            $input = $request->all();
            DB::transaction(function () use ($input) {
                Unit::create($input);
            });
            return redirect()->route('units.index')->with('message', 'Unit created successfully.');
        } catch (\Exception $e) {
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
        $this->authorize('unit-edit');
        $formType = 'edit';
        $unit = Unit::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
        return view('hr::unit.create', compact('formType', 'unit'));
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
            $this->authorize('unit-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                $unit = Unit::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
                $unit->update($input);
            });
            return redirect()->route('units.index')->with('message', 'Unit updated successfully.');
        } catch (\Exception $e) {
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
            $this->authorize('unit-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $unit = Unit::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
                // dd($unit);
                if ($unit->employees->count() === 0) {
                    $unit->delete();
                    $message = ['message'=>'Unit deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('units.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
