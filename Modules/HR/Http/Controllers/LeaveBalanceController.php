<?php

namespace Modules\HR\Http\Controllers;

use Exception;
use App\Department;
use Illuminate\Http\Request;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\LeaveBalance;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveBalanceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // dd('hello');
        $this->authorize('leave-balance-show');
        $leave_balances = LeaveBalance::with('leave_balance_details', 'employee')->latest()->get();
        // dd($leave_balances);
        return view('hr::leave-balance.index', compact('leave_balances'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('leave-balance-create');
        $formType = 'create';
        $departments = Department::pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');

        return view('hr::leave-balance.create', compact('formType', 'departments', 'sections', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('leave-balance-create');

        $message = ['message' => 'Leave Balance created successfully.'];

        try {
            $input = $request->except('_token');
            DB::beginTransaction();

            if (!empty($request->all_emp)) {

                // make maternity leave 0 in case of generating leave balance for all
                $request->merge(['ml' => 0]);

                $employees = Employee::latest()->where('is_active', 1)->get();
                foreach ($employees as $data) {
                    $this->employee_leave_balance_insert($data['id'], $request->input());
                }
            } else if (!empty($request->emp_wise)) {
                $leave_balance_emp = LeaveBalance::where('emp_id', $request->employee_id)->where('year', $request->year)->latest()->first();
                $employee = Employee::find($request->employee_id);

                if ($employee->gender_id == 1 & !empty($request->ml)) {
                    throw new \Exception('Male Employee Can not Enjoy Maternity Leave');
                }


                if (empty($leave_balance_emp)) {
                    $leaveblance = [];
                    $leaveblance['emp_id'] = $request->employee_id;
                    $leaveblance['year'] = $request->year;
                    $leaveblance['com_user_id'] = Auth::user()->id;

                    $leaveblancedetail = [];
                    $leaveblancedetail['cl'] = $request->cl;
                    $leaveblancedetail['sl'] = $request->sl;
                    $leaveblancedetail['el'] = $request->el;
                    $leaveblancedetail['ml'] = $request->ml;
                    $leaveblancedetail['other'] = $request->other;

                    $leaveblance = LeaveBalance::create($leaveblance);
                    $leaveblance->leave_balance_details()->create($leaveblancedetail);
                } else {
                    $message = ['error' => 'This employee data already inserted.'];
                }
            } else if (!empty($request->department)) {

                // make maternity leave 0 in case of generating leave balance for all
                $request->merge(['ml' => 0]);

                $departments = Department::with('employees')->findOrFail($request->department_id);
                if ($departments->employees->count() !== 0) {
                    foreach ($departments->employees as $data) {
                        $this->employee_leave_balance_insert($data['id'], $request->input());
                    }
                }
            } else if (!empty($request->section)) {

                // make maternity leave 0 in case of generating leave balance for all
                $request->merge(['ml' => 0]);

                $sections = Section::with('employees')->findOrFail($request->section_id);
                if ($sections->employees->count() !== 0) {
                    foreach ($sections->employees as $data) {
                        $this->employee_leave_balance_insert($data['id'], $request->input());
                    }
                }
            }

            DB::commit();
            return redirect()->route('leave-balances.index')->with($message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    // for leave balance insert
    public function employee_leave_balance_insert($employee_id, $data)
    {
        $this->authorize('leave-balance-create');
        $leave_balance_emp = LeaveBalance::where('emp_id', $employee_id)->where('year', $data['year'])->latest()->first();

        if (empty($leave_balance_emp)) {
            $leaveblance = [];
            $leaveblance['emp_id'] = $employee_id;
            $leaveblance['year'] = $data['year'];
            $leaveblance['com_user_id'] = Auth::user()->id;

            $leaveblancedetail = [];
            $leaveblancedetail['cl'] = $data['cl'];
            $leaveblancedetail['sl'] = $data['sl'];
            $leaveblancedetail['el'] = $data['el'];
            $leaveblancedetail['ml'] = $data['ml'];
            $leaveblancedetail['other'] = $data['other'];

            $leaveblance = LeaveBalance::create($leaveblance);
            $leaveblance->leave_balance_details()->create($leaveblancedetail);
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
        $this->authorize('leave-balance-edit');
        $formType = 'edit';
        $departments = Department::where('status', 'Active')->pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');
        $leave_balance = LeaveBalance::with('leave_balance_details')->findOrFail($id);
        return view('hr::leave-balance.create', compact('formType', 'departments', 'sections', 'employees', 'leave_balance'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('leave-balance-edit');
        try {
            $input = $request->except('_token');
            DB::beginTransaction();

            $leaveblancedata = [];
            $leaveblancedata['com_user_id'] = Auth::user()->id;

            $leaveblancedetail = [];
            $leaveblancedetail['cl'] = $request->cl;
            $leaveblancedetail['sl'] = $request->sl;
            $leaveblancedetail['el'] = $request->el;
            $leaveblancedetail['ml'] = $request->ml;
            $leaveblancedetail['other'] = $request->other;


            $leaveblance = LeaveBalance::findOrFail($id);
            // dd($leaveblance);
            $leaveblance->update($leaveblancedata);

            $leaveblance->leave_balance_details()->delete();
            $leaveblance->leave_balance_details()->create($leaveblancedetail);
            DB::commit();
            return redirect()->route('leave-balances.index')->with('message', 'Leave Balance Updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
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
