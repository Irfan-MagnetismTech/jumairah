<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\EmployeeShiftEntry;
use Modules\HR\Entities\Shift;
use Modules\HR\Entities\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;

class EmployeeShiftEntryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-shift-show');
        $employee_shifts = EmployeeShiftEntry::with('employee', 'shift')->where('is_active', 1)->orderBy('date', 'DESC')->get();
        // dd($employee_shifts);
        return view('hr::employee-shift-entry.index', compact('employee_shifts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-shift-create');
        $formType = 'create';
        $shifts = Shift::where('status', "active")->latest()->get();
        $employees = Employee::where('is_active', 1)->with('designation', 'shift', 'department', 'section')->latest()->get();

        // dd($shifts);
        return view('hr::employee-shift-entry.create', compact('formType', 'shifts', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('employee-shift-create');
        if (isset($request->shift_id) && isset($request->employee_id)) {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $date_range = CarbonPeriod::create($from_date, $to_date);
            try {
                DB::transaction(function () use ($request, $date_range) {
                    $active = 0;
                    foreach ($date_range as $key => $date) {
                        foreach ($request->employee_id as $emp_id) {
                            $employeeshiftentry = new EmployeeShiftEntry();
                            $employeeshiftentry["date"] = date('Y-m-d', strtotime($date));
                            $employeeshiftentry["shift_id"] = $request->shift_id;
                            $employeeshiftentry["employee_id"] = $emp_id;
                            $employeeshiftentry->save();

                            if (($request->main_shift == "on" && $active == 0)) {
                                $employee = Employee::findOrFail($emp_id);
                                $employee->shift_id = $request->shift_id;
                                $employee->save();
                            }
                        }
                        $active = $request->main_shift;
                    }
                });

                return redirect()->route('employee-shifts.index')->with('message', 'Employee Shift Created Successfully.');
            } catch (QueryException $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'All field is required.')->withInput();
        }
        //






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
        $this->authorize('employee-shift-edit');
        $formType = 'edit';
        $shifts = Shift::where('status', "active")->latest()->get();
        $employees = Employee::where('is_active', 1)->with('designation', 'shift', 'department', 'section')->latest()->get();
        $employee_shift = EmployeeShiftEntry::with('employee')->findOrFail($id);
        // dd($employee_shift);
        return view('hr::employee-shift-entry.edit', compact('formType', 'shifts', 'employees', 'employee_shift'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('employee-shift-edit');
        try {
            DB::transaction(function () use ($request, $id) {
                $employeeshiftentry = EmployeeShiftEntry::findOrFail($id);
                $employeeshiftentry->shift_id = $request->shift_id;
                $employeeshiftentry->save();
            });

            return redirect()->route('employee-shifts.index')->with('message', 'Employee Shift Updated Successfully.');
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
        //
    }
}
