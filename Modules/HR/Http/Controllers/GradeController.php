<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Grade;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GradeController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('grade-show');
        $grades = Grade::latest()->get();
        return view('hr::grade.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('grade-create');
        $formType = 'create';
        return view('hr::grade.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try{
            $this->authorize('grade-create');
            $input = $request->all();
            DB::transaction(function () use ($input) {
                Grade::create($input);
            });
            return redirect()->route('grades.index')->with('message', 'Grade created successfully.');
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
        $this->authorize('grade-edit');
        $formType = 'edit';
        $grade = Grade::findOrFail($id);
        return view('hr::grade.create', compact('formType', 'grade'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try{
            $this->authorize('grade-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                $grade = Grade::findOrFail($id);
                $grade->update($input);
            });
            return redirect()->route('grades.index')->with('message', 'Grade updated successfully.');
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
        try{
            $this->authorize('grade-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $grade = Grade::with('designations','employee_details')->findOrFail($id);
                // dd($grade);
                if ($grade->designations->count() === 0 && $grade->employee_details->count() === 0) {
                    $grade->delete();
                    $message = ['message'=>'Grade deleted successfully.'];
                } else {
                    $message = ['error'=>'This data has some dependency.'];
                }
            });

            return redirect()->route('grades.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
