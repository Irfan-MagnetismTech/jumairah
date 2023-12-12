<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\EmployeeRelease;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\ReleasedType;


class EmployeeReleaseController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-release-show');
        $employee_releases = EmployeeRelease::with('employee', 'release_type')->where('active_status', 1)->latest()->get();
        return view('hr::employee-release.index', compact('employee_releases'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-release-create');
        $formType = 'create';
        $released_types = ReleasedType::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        return view('hr::employee-release.create', compact('formType', 'employees', 'released_types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request);
        $employee_releases = $request->all();

        try {
            $this->authorize('employee-release-create');
            DB::transaction(function () use ($employee_releases) {
                EmployeeRelease::create($employee_releases);
                $employee = Employee::findOrFail($employee_releases['employee_id']);
                $employee->is_active = 0;
                $employee->save();
            });

            return redirect()->route('employee-releases.index')->with('message', 'Employee Release Created Successfully.');
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
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('employee-release-edit');
        $formType = 'edit';
        $released_types = ReleasedType::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::pluck('emp_name', 'id');
        $employee_release = EmployeeRelease::findOrFail($id)->load('employee', 'release_type');
        return view('hr::employee-release.create', compact('formType', 'employees', 'employee_release', 'released_types'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $employee_release = $request->all();
        try {
            $this->authorize('employee-release-edit');
            DB::transaction(function () use ($employee_release, $id) {
                EmployeeRelease::findOrFail($id)->update($employee_release);
                // $employee= Employee::findOrFail($employee_releases['employee_id']);
                // $employee->is_active = 1;
                // $employee->save();
            });

            return redirect()->route('employee-releases.index')->with('message', 'Employee Release Updated successfully.');
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
            $this->authorize('employee-release-delete');
            $employee_release = EmployeeRelease::findOrFail($id);

            // employee table update
            $employee = Employee::findOrFail($employee_release->employee_id);
            $employee->is_active = 1;
            $employee->save();
            // Employee Release table update
            $employee_release->active_status = 0;
            $employee_release->save();

            return redirect()->route('employee-releases.index')->with('message', 'Employee Release Delete successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
