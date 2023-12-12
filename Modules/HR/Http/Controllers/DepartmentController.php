<?php

namespace Modules\HR\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepartmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('department-show');
        $departments = Department::latest()->get();
        return view('hr::department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('department-create');
        $formType = "create";
        return view('hr::department.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('department-create');
            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Department::create($input);
            });

            return redirect()->route('departments.index')->with('message', 'Department information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('departments.edit')->withInput()->withErrors($e->getMessage());
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
        $this->authorize('department-edit');
        $formType  = "edit";
        $department = Department::where('id', $id)->first();
        return view('hr::department.create', compact('department', 'formType'));
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
            $this->authorize('department-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $department = Department::where('id', $id)->first();
                $department->update($input);
            });

            return redirect()->route('departments.index')->with('message', 'Department information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('departments.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('department-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $department = Department::with('employees')->where('id', $id)->first();
                if ($department->employees->count() === 0) {
                    $department->delete();

                    $message = ['message' => 'Department information deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });
            // dd($message);
            return redirect()->route('departments.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('departments.edit')->withInput()->withErrors($e->getMessage());
        }
    }

    /*
     * Generate the department list report
    */
    public function generateDepartmentListReport()
    {
        $this->authorize('department-show');
        $reportData = Department::whereStatus('Active')->latest()->get();
        $print_date_time = Carbon::now();
        $print_date_time->timezone('Asia/Dhaka');

        $pdf = PDF::loadView('hr::department.department-list-report', compact('print_date_time', 'reportData'),  [], [
            'watermark'     => auth()->user()->company->company_name,
            'show_watermark'   => true,
            'title' => 'Department Report',
            'format' => 'A4-P',
        ]);

        return $pdf->stream('department-list-report.pdf');
    }
}
