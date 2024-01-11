<?php

namespace Modules\HR\Http\Controllers;

use App\Designation;
use Illuminate\Http\Request;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\EmployeeType;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\EmployeeSalary;
use Modules\HR\Entities\EmployeeIncrement;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeIncrementController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-increment-show');
        $employee_increments = EmployeeIncrement::where('increment_status', 1)->latest()->get();
        // dd($employee_increments);
        return view('hr::employee-increment.index', compact('employee_increments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-increment-create');
        $formType = 'create';
        $designations = Designation::orderBy('name')->pluck('name', 'id');
        $employee_types = EmployeeType::orderBy('name')->pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');
        // $employee_salary = Employee::with('employee_salary')->where('is_active', 1)->where('com_id', Auth::user()->com_id)->get();
        // dd($employee_salary);
        return view('hr::employee-increment.create', compact('formType', 'designations', 'employee_types', 'sections', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd('fd');
        try {
            $this->authorize('employee-increment-create');
            $date = date('Y-m-d', strtotime($request->date));
            // for insert Employee Increment table

            DB::beginTransaction();
            $emp_increment = new EmployeeIncrement();
            $emp_increment['employee_id'] = $request->employee_id;
            $emp_increment['incement_type'] = $request->incement_type;
            $emp_increment['date'] = $date;
            $emp_increment['old_designation_id'] = $request->old_designation_id;
            $emp_increment['old_section_id'] = $request->old_section_id;
            $emp_increment['old_emp_type_id'] = $request->old_emp_type_id;

            if ($request->incement_type != "Increment") {
                $emp_increment['new_section_id'] = $request->new_section_id;
                $emp_increment['new_designation_id'] = $request->new_designation_id;
                $emp_increment['new_emp_type_id'] = $request->new_emp_type_id;
            }

            $emp_increment['old_gs'] = $request->old_gs;
            $emp_increment['old_bs'] = $request->old_bs;
            $emp_increment['old_hr'] = $request->old_hr;
            $emp_increment['old_ta'] = $request->old_ta;
            $emp_increment['old_fa'] = $request->old_fa;
            $emp_increment['old_ma'] = $request->old_ma;

            $emp_increment['new_gs'] = $request->new_gs;
            $emp_increment['new_bs'] = $request->new_bs;
            $emp_increment['new_hr'] = $request->new_hr;
            $emp_increment['new_ta'] = $request->new_ta;
            $emp_increment['new_fa'] = $request->new_fa;
            $emp_increment['new_ma'] = $request->new_ma;
            $emp_increment['remarks'] = "Yes";

            if ($request->incement_type != "Increment" || $request->incement_type != "Increment with Promotion") {
                $emp_increment['increment_amount'] = round($request->increment_amount);
                $emp_increment['increment_percentage'] = $request->increment_percentage;
            }

            $emp_increment->save();

            // for update Employee table
            $employee = Employee::findOrFail($request->employee_id);
            if ($request->incement_type == "Increment") {
                $employee->increment_date = $date;
            } else if ($request->incement_type == "Increment with Promotion") {
                $employee->increment_date = $date;
                $employee->promotion_date = $date;
            } else {
                $employee->promotion_date = $date;
            }
            $employee->save();



            // for update salary table

            $employeesalary = EmployeeSalary::where('employee_id', $request->employee_id)->first();

            $employeesalary->gross_salary = $request->new_gs;
            $employeesalary->basic_salary = $request->new_bs;
            $employeesalary->house_rent = $request->new_hr;
            $employeesalary->tansport_allowance = $request->new_ta;
            $employeesalary->food_allowance = $request->new_fa;
            $employeesalary->medical_allowance = $request->new_ma;

            $employeesalary->save();


            DB::commit();
            return redirect()->route('employee-increments.index')->with('message', 'Employee Salary Increment Update successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
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
        $this->authorize('employee-increment-edit');
        $formType = 'edit';
        $designations = Designation::where('status', 'Active')->where('com_id', Auth::user()->com_id)->pluck('name', 'id');
        $employee_types = EmployeeType::where('status', 'Active')->where('com_id', Auth::user()->com_id)->pluck('name', 'id');
        $sections = Section::where('status', 'Active')->where('com_id', Auth::user()->com_id)->pluck('name', 'id');
        $employees = Employee::where('is_active', 1)->where('com_id', Auth::user()->com_id)->pluck(DB::raw("CONCAT(emp_name, ' - ', emp_code) AS emp_name"), 'id');
        $employee_increment = EmployeeIncrement::findOrFail($id)->load('employee', 'old_designation', 'new_designation', 'old_section', 'new_section', 'old_emp_type', 'new_emp_type');

        return view('hr::employee-increment.create', compact('formType', 'designations', 'employee_types', 'sections', 'employees', 'employee_increment'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('employee-increment-delete');
        $increment_delete = EmployeeIncrement::findOrFail($id);
        $increment_delete->increment_status = 0;
        $increment_delete->save();
        return redirect()->route('employee-increments.index')->with('message', 'Employee Salary Increment Delete successfully.');
    }

    public function getSingleEmployeeIncrementSalary(Request $request)
    {
        $this->authorize('employee-increment-show');
        $employee_increment = EmployeeIncrement::with('employee', 'old_designation', 'new_designation', 'old_section', 'new_section', 'old_emp_type', 'new_emp_type')->findOrFail($request->employee_id);
        // dd($employee_increment);
        return $employee_increment;
    }
}
