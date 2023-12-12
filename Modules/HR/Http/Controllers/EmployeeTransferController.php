<?php

namespace Modules\HR\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\EmployeeTransfer;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\Department;
use Modules\HR\Entities\Designation;
use Modules\HR\Entities\EmployeeType;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\EmployeeSalary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeTransferController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-transfer-show');
        $employee_transfers = EmployeeTransfer::where("is_active", 1)->latest()->get();
        // dd($employee_transfers);
        return view('hr::employee-transfer.index', compact('employee_transfers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-transfer-create');
        $formType = 'create';
        $departments = Department::pluck('name', 'id');
        $designations = Designation::pluck('name', 'id');
        $employee_types = EmployeeType::pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');

        return view('hr::employee-transfer.create', compact('formType', 'designations', 'departments', 'employee_types', 'sections', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        // dd($request);

        try {

            $this->authorize('employee-transfer-create');

            $date = date('Y-m-d', strtotime($request->date));
            $join_date = date('Y-m-d', strtotime($request->join_date));
            // for insert Employee Increment table
            $employee_transfer = new EmployeeTransfer();
            $employee_transfer['employee_id'] = $request->employee_id;
            $employee_transfer['transfer_type'] = $request->transfer_type;
            $employee_transfer['transfer_date'] = $date;
            $employee_transfer['join_date'] = $join_date;
            $employee_transfer['old_department_id'] = $request->old_department_id;
            $employee_transfer['old_designation_id'] = $request->old_designation_id;
            $employee_transfer['old_section_id'] = $request->old_section_id;
            $employee_transfer['old_emp_type_id'] = $request->old_emp_type_id;

            if ($request->transfer_type == "Department") {
                $employee_transfer['new_department_id'] = $request->new_department_id;
            }
            if ($request->transfer_type == "Designation") {
                $employee_transfer['new_designation_id'] = $request->new_designation_id;
            }
            if ($request->transfer_type == "Section") {
                $employee_transfer['new_section_id'] = $request->new_section_id;
            }
            if ($request->transfer_type == "Employee Type") {
                $employee_transfer['new_emp_type_id'] = $request->new_emp_type_id;
            }

            $employee_transfer['remarks'] = "Yes";
            $employee_transfer['com_id'] = Auth::user()->com_id;
            $employee_transfer->save();

            return redirect()->route('employee-transfers.index')->with('message', 'Employee Salary Increment Update successfully.');
        } catch (Exception $e) {
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
        $this->authorize('employee-transfer-edit');
        $formType = 'edit';
        $departments = Department::where('status', 'Active')->pluck('name', 'id');
        $designations = Designation::where('status', 'Active')->pluck('name', 'id');
        $employee_types = EmployeeType::pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $employee_transfers = Employeetransfer::findOrFail($id)->load('employee', 'old_department', 'new_department', 'old_designation', 'new_designation', 'old_section', 'new_section', 'old_emp_type', 'new_emp_type');

        // dd($employee_transfers);
        return view('hr::employee-transfer.create', compact('formType', 'departments', 'designations', 'employee_types', 'sections', 'employees', 'employee_transfers'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        try {

            $this->authorize('employee-transfer-edit');

            $date = date('Y-m-d', strtotime($request->date));
            $join_date = date('Y-m-d', strtotime($request->join_date));
            // for insert Employee Increment table
            $employee_transfer = EmployeeTransfer::findOrFail($id);
            $employee_transfer->employee_id = $request->employee_id;
            $employee_transfer->transfer_type = $request->transfer_type;
            $employee_transfer->transfer_date = $date;
            $employee_transfer->join_date = $join_date;
            $employee_transfer->old_department_id = $request->old_department_id;
            $employee_transfer->old_designation_id = $request->old_designation_id;
            $employee_transfer->old_section_id = $request->old_section_id;
            $employee_transfer->old_emp_type_id = $request->old_emp_type_id;

            if ($request->transfer_type == "Department") {
                $employee_transfer->new_department_id = $request->new_department_id;
            }
            if ($request->transfer_type == "Designation") {
                $employee_transfer->new_designation_id = $request->new_designation_id;
            }
            if ($request->transfer_type == "Section") {
                $employee_transfer->new_section_id = $request->new_section_id;
            }
            if ($request->transfer_type == "Employee Type") {
                $employee_transfer->new_emp_type_id = $request->new_emp_type_id;
            }

            $employee_transfer->remarks = "Yes";
            $employee_transfer->com_id = Auth::user()->com_id;
            $employee_transfer->save();

            return redirect()->route('employee-transfers.index')->with('message', 'Employee Transfer Update successfully.');
        } catch (Exception $e) {
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
        // dd($id);
        $this->authorize('employee-transfer-delete');
        $increment_delete = EmployeeTransfer::findOrFail($id);
        $increment_delete->is_active = 0;
        $increment_delete->save();
        return redirect()->route('employee-transfers.index')->with('message', 'Employee Salary Increment Delete successfully.');
    }

    public function getSingleEmployeeTransfer(Request $request)
    {
        $this->authorize('employee-transfer-show');
        $employee_transfer = EmployeeTransfer::with('employee', 'old_department', 'new_department', 'old_designation', 'new_designation', 'old_section', 'new_section', 'old_emp_type', 'new_emp_type')->findOrFail($request->employee_id);
        return $employee_transfer;
    }
}
