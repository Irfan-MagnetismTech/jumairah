<?php

namespace Modules\HR\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\EmployeeSalary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\SalarySetting;

class EmployeeSalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-salary-show');
        $employee_salaries = EmployeeSalary::latest()->get();
        return view('hr::employee-salary.index', compact('employee_salaries'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-salary-create');
        $formType = 'create';
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        return view('hr::employee-salary.create', compact('formType', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('employee-salary-create');
        $employee_salary = $request->all();

        try {
            DB::transaction(function () use ($employee_salary) {
                EmployeeSalary::create($employee_salary);
            });

            return redirect()->route('employee-salaries.index')->with('message', 'Employee Salary Created successfully.');
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
        $this->authorize('employee-salary-edit');
        $formType = 'edit';
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $employee_salary = EmployeeSalary::findOrFail($id);
        return view('hr::employee-salary.create', compact('formType', 'employees', 'employee_salary'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('employee-salary-edit');

        $employee_salary = $request->all();
        try {

            DB::transaction(function () use ($employee_salary, $id) {
                EmployeeSalary::findOrFail($id)->update($employee_salary);
            });

            return redirect()->route('employee-salaries.index')->with('message', 'Employee Salary Updated successfully.');
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

    public function getEmployeeTypeSalary(Request $request)
    {
        $this->authorize('employee-salary-show');
        $employee_id = $request->input('employee_id');
        $employee = Employee::where('id', $employee_id)->with('designation', 'department', 'section', 'employee_type', 'employee_salary')->first();
        $employee_salary = SalarySetting::where('employee_type_id', $employee->employee_type_id)->first();

        return ['employee' => $employee, 'employee_salary' => $employee_salary];
    }
}
