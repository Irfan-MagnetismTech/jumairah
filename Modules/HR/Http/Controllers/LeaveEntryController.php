<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\LeaveBalance;
use Modules\HR\Entities\LeaveBalanceDetail;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\LeaveType;
use Modules\HR\Entities\LeaveEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeaveEntryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('leave-entry-show');
        $leave_entries = LeaveEntry::with('leave_type', 'employee')->latest()->get();
        // dd($leave_entries);
        return view('hr::employee-leave-entry.index', compact('leave_entries'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('leave-entry-show');
        $formType = 'create';

        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $leave_types = LeaveType::where('is_active', 1)->pluck('name', 'id');

        return view('hr::employee-leave-entry.create', compact('formType', 'employees', 'leave_types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('leave-entry-show');
        try {

            DB::transaction(function () use ($request) {
                $leave_entry = $request->except(
                    '_token',
                    'leave_type_name',
                    'approve_save',
                    'save'
                );
                if ($request->has('approve_save')) {
                    $leave_entry['is_approved'] = 1;
                    $leave_entry['approved_com_id'] = Auth::user()->id;

                    $leave_balance = LeaveBalance::where('emp_id', $request->emp_id)->with('leave_balance_details')->where('year', $request->leave_year)->firstOrFail();

                    $leave_bal_detail = [];
                    if ($request->leave_type_name == "Casual Leave") {
                        $leave_bal_detail['cl_enjoyed'] = $leave_balance->leave_balance_details->cl_enjoyed + $request->total_day;
                    } else if ($request->leave_type_name == "Sick Leave") {
                        $leave_bal_detail['sl_enjoyed'] = $leave_balance->leave_balance_details->sl_enjoyed + $request->total_day;
                    } else if ($request->leave_type_name == "Earned Leave") {
                        $leave_bal_detail['el_enjoyed'] = $leave_balance->leave_balance_details->el_enjoyed + $request->total_day;
                    } else if ($request->leave_type_name == "Maternity Leave") {
                        $leave_bal_detail['ml_enjoyed'] = $leave_balance->leave_balance_details->ml_enjoyed + $request->total_day;
                    } else {
                        $leave_bal_detail['other_enjoyed'] = $leave_balance->leave_balance_details->other_enjoyed + $request->total_day;
                    }

                    $leave_datail = LeaveBalanceDetail::where('leave_balance_id', $leave_balance->id)->update($leave_bal_detail);

                    LeaveEntry::create($leave_entry);
                } else {
                    LeaveEntry::create($leave_entry);
                }
            });

            return redirect()->route('leave-entries.index')->with('message', 'Leave Entry created successfully.');
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
        $this->authorize('leave-entry-edit');
        $formType = 'edit';

        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $leave_types = LeaveType::where('is_active', 1)->pluck('name', 'id');
        $leave_entry = LeaveEntry::with('leave_type')->findOrFail($id);

        // dd($leave_entry);
        $leave_balance = LeaveBalance::where('emp_id', $leave_entry->emp_id)
            ->where('year', $leave_entry->leave_year)
            ->with('leave_balance_details', 'employee')
            ->firstOrFail();

        // dd($leave_balance);
        return view('hr::employee-leave-entry.create', compact('formType', 'employees', 'leave_types', 'leave_entry', 'leave_balance'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('leave-entry-edit');
        try {
            $message = ['message' => 'Leave Entry updated successfully.'];
            DB::transaction(function () use ($request, $id, &$message) {
                $leave_entry = $request->except(
                    '_token',
                    'leave_type_name',
                    'approve_save',
                    'save'
                );

                $leave_entry_get = LeaveEntry::findOrFail($id);
                if ($leave_entry_get->is_approved != 1) {
                    if ($request->has('approve_save')) {
                        $leave_entry['is_approved'] = 1;
                        $leave_entry['approved_com_id'] = Auth::user()->id;

                        $leave_balance = LeaveBalance::where('emp_id', $request->emp_id)->with('leave_balance_details')->where('year', $request->leave_year)->firstOrFail();

                        $leave_bal_detail = [];
                        if ($request->leave_type_name == "Casual Leave") {
                            $leave_bal_detail['cl_enjoyed'] = $leave_balance->leave_balance_details->cl_enjoyed + $request->total_day;
                        } else if ($request->leave_type_name == "Sick Leave") {
                            $leave_bal_detail['sl_enjoyed'] = $leave_balance->leave_balance_details->sl_enjoyed + $request->total_day;
                        } else if ($request->leave_type_name == "Earned Leave") {
                            $leave_bal_detail['el_enjoyed'] = $leave_balance->leave_balance_details->el_enjoyed + $request->total_day;
                        } else if ($request->leave_type_name == "Maternity Leave") {
                            $leave_bal_detail['ml_enjoyed'] = $leave_balance->leave_balance_details->ml_enjoyed + $request->total_day;
                        } else {
                            $leave_bal_detail['other_enjoyed'] = $leave_balance->leave_balance_details->other_enjoyed + $request->total_day;
                        }

                        $leave_datail = LeaveBalanceDetail::where('leave_balance_id', $leave_balance->id)->update($leave_bal_detail);

                        $leave_entry_get->update($leave_entry);
                    } else {
                        $leave_entry_get->update($leave_entry);
                    }
                } else {
                    $message = ['error' => 'This Application Already Approved.'];
                }
            });

            return redirect()->route('leave-entries.index')->with($message);
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
        $this->authorize('leave-entry-delete');
        try {
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $leave_entry = LeaveEntry::findOrFail($id);

                if ($leave_entry->is_approved != 1) {
                    $leave_entry->delete();
                    $message = ['message' => 'Leave Application deleted successfully.'];
                } else {
                    $message = ['error' => 'This Application Already Approved.'];
                }
            });

            return redirect()->route('leave-entries.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function getEmployeeLeaves(Request $request)
    {
        $this->authorize('leave-entry-show');

        $employee_id = $request->input('employee_id');
        $year = $request->input('year');
        $leave_balance = LeaveBalance::where('emp_id', $employee_id)
            ->where('year', $year)
            ->with('leave_balance_details', 'employee')
            ->first();

        $leave_entry = LeaveEntry::where('emp_id', $employee_id)->with('leave_type')
            ->where('is_approved', 0)->latest()->first();

        return ['leave_balance' => $leave_balance, 'leave_entry' => $leave_entry];
    }

    public function approve($id)
    {
        $this->authorize('leave-entry-approve');
        try {
            $message = ['message' => 'Approved successfully.'];
            DB::transaction(function () use ($id, &$message) {

                $leave_entry = LeaveEntry::with('leave_type')->findOrFail($id);

                $leave_balance = LeaveBalance::where('emp_id', $leave_entry->emp_id)->with('leave_balance_details')->where('year', $leave_entry->leave_year)->firstOrFail();

                $leave_bal_detail = [];
                if ($leave_entry->leave_type->name == "Casual Leave") {
                    $leave_bal_detail['cl_enjoyed'] = $leave_balance->leave_balance_details->cl_enjoyed + $leave_entry->total_day;
                } else if ($leave_entry->leave_type->name == "Sick Leave") {
                    $leave_bal_detail['sl_enjoyed'] = $leave_balance->leave_balance_details->sl_enjoyed + $leave_entry->total_day;
                } else if ($leave_entry->leave_type->name == "Earned Leave") {
                    $leave_bal_detail['el_enjoyed'] = $leave_balance->leave_balance_details->el_enjoyed + $leave_entry->total_day;
                } else if ($leave_entry->leave_type->name == "Maternity Leave") {
                    $leave_bal_detail['ml_enjoyed'] = $leave_balance->leave_balance_details->ml_enjoyed + $leave_entry->total_day;
                } else {
                    $leave_bal_detail['other_enjoyed'] = $leave_balance->leave_balance_details->other_enjoyed + $leave_entry->total_day;
                }

                $leave_datail = LeaveBalanceDetail::where('leave_balance_id', $leave_balance->id)->update($leave_bal_detail);

                $leave_entry->is_approved = 1;
                $leave_entry->approved_com_id = Auth::user()->id;
                $leave_entry->save();
            });

            return redirect()->route('leave-entries.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request)
    {
        $this->authorize('leave-entry-reject');
        try {
            $message = ['message' => 'Reject successfully.'];
            DB::transaction(function () use ($request, &$message) {
                $leave_entry = LeaveEntry::findOrFail($request->leave_entry_id);
                $leave_entry->is_reject = 1;
                $leave_entry->remarks = $request->remarks;
                $leave_entry->approved_com_id = Auth::user()->id;
                $leave_entry->save();
            });

            return redirect()->route('leave-entries.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
