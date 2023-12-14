<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\HR\Entities\Shift;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDF;

class ShiftController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('shift-show');
        $shifts = Shift::where('com_id', auth()->user()->com_id)->latest()->get();
        return view('hr::shift.index', compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('shift-create');
        $formType = 'create';
        return view('hr::shift.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('shift-create');
            $input = $request->all();
            DB::transaction(function () use ($input) {
                Shift::create($input);
            });
            return redirect()->route('shifts.index')->with('message', 'Shift created successfully.');
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
        $this->authorize('shift-edit');
        $formType = 'edit';
        $shift = Shift::where('com_id', auth()->user()->com_id)->where('id',$id)->first();
        return view('hr::shift.create', compact('formType', 'shift'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            $this->authorize('shift-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                Shift::where('com_id', auth()->user()->com_id)->where('id',$id)->first()->update($input);
            });
            return redirect()->route('shifts.index')->with('message', 'Shift updated successfully.');
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
        try {
            $this->authorize('shift-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $shift = Shift::with('employees', 'employeeshiftentry')
                ->where('com_id', auth()->user()->com_id)
                ->where('id',$id)
                ->first();
                if ($shift->employees->count() === 0 && $shift->employeeshiftentry->count() === 0) {
                    $shift->delete();
                    $message = ['message' => 'Shift deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('shifts.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /*
     * Shift Report
    */
    public function generateShiftReport()
    {
        $this->authorize('shift-show');
        $reportData = Shift::whereStatus('Active')->where('com_id', auth()->user()->com_id)->latest()->get();
        $print_date_time = Carbon::now();
        $print_date_time->timezone('Asia/Dhaka');

        $pdf = PDF::loadView('hr::shift.shift-report', compact('print_date_time', 'reportData'),  [], [
            ...watermarkImageSettings(),
            'title' => 'Shift Report',
            'format' => 'A4-L',
        ]);

        return $pdf->stream('customer-list-report.pdf');
    }
}
