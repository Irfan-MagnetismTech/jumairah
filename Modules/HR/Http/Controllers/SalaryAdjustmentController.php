<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\SalaryAdjustment;
use Modules\HR\Entities\Employee;

class SalaryAdjustmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('salary-adjustment-show');
        $salary_adjustments = SalaryAdjustment::with('employee')->latest()->get();
        // dd($salary_adjustments);
        return  view('hr::salary-adjustment.index', compact('salary_adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('salary-adjustment-create');
        $formType = 'create';
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');
        return view('hr::salary-adjustment.create', compact('formType', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('salary-adjustment-create');
        $request->validate([
            'month_year' => 'required',
            'employee_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'required',

        ]);
        try {
            $input = $request->all();
            DB::transaction(function () use ($input) {
                SalaryAdjustment::create($input);
            });
            return redirect()->route('salary-adjustments.index')->with('message', 'Police Station created successfully.');
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
        $this->authorize('salary-adjustment-edit');
        $formType = 'edit';
        $salary_adjustment = SalaryAdjustment::find($id);
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');
        return view('hr::salary-adjustment.create', compact('formType', 'employees', 'salary_adjustment'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('salary-adjustment-edit');

        $request->validate([
            'month_year' => 'required',
            'employee_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'required',
            'type' => 'required',
        ]);

        try {
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                SalaryAdjustment::find($id)->update($input);
            });
            return redirect()->route('salary-adjustments.index')->with('success', 'Religion Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('salary-adjustment-delete');
        try {
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                // dd($id);
                $salary_adjustment = SalaryAdjustment::findOrFail($id);
                // dd($salary_adjustment);
                if ($salary_adjustment->status == 1) {
                    $salary_adjustment->delete();
                    $message = ['message' => 'Religion deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('salary-adjustments.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
