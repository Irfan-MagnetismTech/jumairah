<?php

namespace Modules\HR\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Allowance;
use Modules\HR\Entities\AllowanceType;
use Modules\HR\Entities\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AllowanceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('allowance-show');
        $allowances = Allowance::where('com_id', auth()->user()->com_id)->with('employee','allowance_type')->latest()->get();
        return view('hr::allowance.index', compact('allowances'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $this->authorize('allowance-create');
        $formType = "create";
        $employees = Employee::where('is_active', 1)->where('com_id', Auth::user()->com_id)->pluck(DB::raw("CONCAT(emp_name, ' - ', emp_code) AS emp_name"),'id');
        $allowanceTypes = AllowanceType::pluck('name','id');
        return view('hr::allowance.create', compact('formType','employees','allowanceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('allowance-create');
        try {

            $input = $request->all();
            DB::transaction(function () use ($input, $request) {
                Allowance::create($input);
            });

            return redirect()->route('allowances.index')->with('message', 'Allowance information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('allowances.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('allowance-show');
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('allowance-edit');
        $formType = "edit";
        $employees = Employee::where('is_active', 1)->where('com_id', Auth::user()->com_id)->pluck(DB::raw("CONCAT(emp_name, ' - ', emp_code) AS emp_name"),'id');
        $allowanceTypes = AllowanceType::pluck('name','id');
        $allowance = Allowance::find($id);
        return view('hr::allowance.create', compact('formType','employees','allowanceTypes','allowance'));
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
            $this->authorize('allowance-edit');
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $allowance = Allowance::where('com_id', auth()->user()->com_id)->findOrFail($id);
                $allowance->update($input);
            });

            return redirect()->route('allowances.index')->with('message', 'Allowance information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('allowances.edit')->withInput()->withErrors($e->getMessage());
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
            $this->authorize('allowance-delete');
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                Allowance::where('com_id', auth()->user()->com_id)->findOrFail($id)->delete();
                $message = ['message'=>'Allowance information deleted successfully.'];
            });

            return redirect()->route('allowances.index')->with($message);
        } catch (Exception $e) {
            return redirect()->route('allowances.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
