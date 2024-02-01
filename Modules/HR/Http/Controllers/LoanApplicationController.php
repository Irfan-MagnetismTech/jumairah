<?php

namespace Modules\HR\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\LoanApplication;
use Illuminate\Contracts\Support\Renderable;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $loanApplications = LoanApplication::with('employee', 'loan_type')->get();
        // dd($loanApplications);
        return view('hr::loan-application.index', compact('loanApplications'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
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
        try {
            $input = $request->all();
            DB::beginTransaction();
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
        return view('hr::edit');
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
