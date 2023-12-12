<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Gender;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GenderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('gender-show');
        $gender = Gender::latest()->get();
        return view('hr::gender.index', compact('gender'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('gender-create');
        $formType = 'create';
        return view('hr::gender.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('gender-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Gender::create($input);
            });

            return redirect()->route('genders.index')->with('message', 'Gender created successfully.');
        }
        catch (QueryException $e) {
            return redirect()->route('genders.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('gender-edit');
        $formType = 'edit';
        $gender = Gender::findOrFail($id);
        return view('hr::gender.create', compact('formType', 'gender'));
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
            $this->authorize('gender-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $gender = Gender::findOrFail($id);
                $gender->update($input);
            });
            return redirect()->route('genders.index')->with('message', 'Gender updated successfully.');
        }
        catch (QueryException $e) {
            return redirect()->route('genders.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('gender-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $gender = Gender::with('employees')->findOrFail($id);
                // dd($gender);
                if ($gender->employees->count() === 0) {
                    $gender->delete();
                    $message = ['message'=>'Gender deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('genders.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('genders.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
