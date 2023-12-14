<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\ReleasedType;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReleasedTypeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('released-type-show');
        $released_type = ReleasedType::latest()->get();
        return view('hr::released-type.index', compact('released_type'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('released-type-create');
        $formType = 'create';
        return view('hr::released-type.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('released-type-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                ReleasedType::create($input);
            });

            return redirect()->route('released-types.index')->with('message', 'Released Type created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('released-types.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('released-type-edit');
        $formType = 'edit';
        $released_type = ReleasedType::findOrFail($id);
        return view('hr::released-type.create', compact('formType', 'released_type'));
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
            $this->authorize('released-type-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $released_type = ReleasedType::findOrFail($id);
                $released_type->update($input);
            });

            return redirect()->route('released-types.index')->with('message', 'Released Type updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('released-types.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('released-type-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $released_type = ReleasedType::with('employeeReleases')->findOrFail($id);
                // dd($released_type);
                if ($released_type->employeeReleases->count() === 0) {
                    $released_type->delete();
                    $message = ['message'=>'Released Type deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('released-types.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('released-types.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
