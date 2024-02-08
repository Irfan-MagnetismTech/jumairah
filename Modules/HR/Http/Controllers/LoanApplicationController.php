<?php

namespace Modules\HR\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\LoanApplication;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;





class LoanApplicationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('loan-application-index');
        $loanApplications = LoanApplication::with('employee', 'loan_type')->latest()->get();
        // dd($loanApplications);
        return view('hr::loan-application.index', compact('loanApplications'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('loan-application-create');
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $formType = 'create';
        return view('hr::loan-application.create', compact('employees', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('loan-application-store');
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['left_amount'] = $input['loan_amount'];
            LoanApplication::create($input);
            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Appliaction created Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-applications.create')->withInput()->withErrors($e->getMessage());
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

        $this->authorize('loan-application-edit');
        $loanApplication = LoanApplication::findOrFail($id);
        $employees = Employee::where('is_active', 1)->pluck('emp_name', 'id');
        $formType = 'edit';
        return view('hr::loan-application.create', compact('loanApplication', 'employees', 'formType'));
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
            $this->authorize('loan-application-update');
            $input = $request->all();
            DB::beginTransaction();
            $loanApplication = LoanApplication::findOrFail($id);
            $loanApplication->update($input);
            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Appliaction updated Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-applications.edit', $id)->withInput()->withErrors($e->getMessage());
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
            $this->authorize('loan-application-delete');
            DB::beginTransaction();
            $loanApplication = LoanApplication::findOrFail($id);
            $loanApplication->delete();
            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Appliaction deleted Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-applications.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
