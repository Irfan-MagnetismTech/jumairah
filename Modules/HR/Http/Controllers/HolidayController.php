<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Holiday;
use Modules\HR\Entities\LeaveEntry;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HolidayController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('holiday-show');
        $formType = 'create';
        $holidays = Holiday::latest()->get();
        return view('hr::holiday-setup.index', compact('formType', 'holidays'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('holiday-create');
        return view('hr::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('holiday-create');
            $input = $request->except('_token');
            DB::beginTransaction();
            Holiday::create($input);
            DB::commit();
            return redirect()->route('holidays.index')->with('message', 'Holiday created successfully.');
        } catch (\Exception $e) {
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
        $this->authorize('holiday-edit');
        $formType = 'edit';
        $holiday = Holiday::findOrFail($id);
        $holidays = Holiday::latest()->get();
        return view('hr::holiday-setup.index', compact('formType', 'holiday', 'holidays'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('holiday-edit');

        try {
            $input = $request->except('_token', '_method');
            DB::beginTransaction();
            Holiday::where('id', $id)->update($input);
            DB::commit();
            return redirect()->route('holidays.index')->with('message', 'Holiday updated successfully.');
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
        $this->authorize('holiday-delete');
        try {
            DB::beginTransaction();
            Holiday::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('holidays.index')->with('message', 'Holiday deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // check leave and holiday
    public function getHolidayOrLeave(Request $request)
    {
        $this->authorize('holiday-show');
        $date = $request->input('date');
        $holidays = Holiday::whereDate('date',$date)->where('type','h')->latest()->first();

        $leave_entry = LeaveEntry::with('leave_type')
        ->where('emp_id', $request->employee_id)
        ->where(function ($query) use ($date) {
            $query->where('from_date', '<=', $date)
                  ->where('to_date', '>=', $date);
        })
        ->where('is_approved', 1)
        ->latest()
        ->first();

        return ['holiday'=>$holidays,'leave'=>$leave_entry];

    }
}
