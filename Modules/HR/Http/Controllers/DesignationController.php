<?php

namespace Modules\HR\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Designation;
use Illuminate\Http\Request;
use Modules\HR\Entities\Grade;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DesignationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('designation-show');
        $designations = Designation::latest()->get();
        // dd($designations[0]);
        return view('hr::designation.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('designation-create');
        $formType = 'create';
        $grades = Grade::orderBy('name')->pluck('name', 'id');
        return view('hr::designation.create', compact('formType', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('designation-create');
            $input = $request->all();
            DB::transaction(function () use ($input) {
                Designation::create($input);
            });
            return redirect()->route('designations.index')->with('message', 'Designation created successfully.');
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
        $this->authorize('designation-edit');
        $formType = 'edit';
        $designation = Designation::where('id', $id)->first();
        $grades = Grade::orderBy('name')->pluck('name', 'id');
        return view('hr::designation.create', compact('formType', 'designation', 'grades'));
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
            $this->authorize('designation-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $id) {
                Designation::findOrFail($id)->update($input);
            });
            return redirect()->route('designations.index')->with('message', 'Designation updated successfully.');
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
            $this->authorize('designation-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $designation = Designation::with('employees')->where('id', $id)->first();
                if ($designation->employees->count() === 0) {
                    $designation->delete();
                    $message = ['message' => 'Designation deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });
            // dd($message);
            return redirect()->route('designations.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /*
     * Generate the designation list report
    */
    public function generateDesignationListReport()
    {
        $this->authorize('designation-show');
        $reportData = Designation::whereStatus('Active')->latest()->get();
        $print_date_time = Carbon::now();
        $print_date_time->timezone('Asia/Dhaka');

        $pdf = PDF::loadView('hr::designation.designation-list-report', compact('print_date_time', 'reportData'),  [], [
            'watermark'     => auth()->user()->company->company_name,
            'show_watermark'   => true,
            'title' => 'Department Report',
            'format' => 'A4-P',
        ]);

        return $pdf->stream('designation-list-report.pdf');
    }
}
