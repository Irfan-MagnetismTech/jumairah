<?php

namespace Modules\HR\Http\Controllers;

use PDF;
use App\Department;
use Illuminate\Http\Request;
use Modules\HR\Entities\Bonus;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\ProcessedBonus;
use Modules\SupplyChain\Entities\Product;
use Illuminate\Contracts\Support\Renderable;
use Modules\SupplyChain\Entities\ProductType;
use Modules\SupplyChain\Entities\ProductRequisition;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\SupplyChain\Entities\ProductPurchaseRequisition;


class ProcessedBonusController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('process-bonus-show');
        $processed_bonuses = ProcessedBonus::latest()->get();
        // return view('hr::index');
        return view('hr::bonus-process.index', compact('processed_bonuses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('process-bonus-create');
        $formType = 'create';
        $bonuses = Bonus::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $employees = [];
        return view('hr::bonus-process.create', compact('formType', 'bonuses', 'departments', 'employees'));
        // return view('hr::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('process-bonus-create');
        try {
            $request->validate([
                'date' => 'required',
                'bonus_id' => 'required',
                'department_id' => 'required',

            ]);

            $processed_bonus_info = $request->only('bonus_id', 'date');
            // dd($request);

            // DB::transaction(function () use ($processed_bonus_info, $request) {
                $processed_bonus = ProcessedBonus::create($processed_bonus_info);

                DB::insert("
                    INSERT INTO processed_bonus_details (employee_id, processed_bonus_id, bonus_name, employee_type_id, department_id, section_id, shift_id, designation_id, bonus_amount, com_id)
                    SELECT
                        es.employee_id,
                        ? as processed_bonus_id,
                        ? as bonus_name,
                        em.employee_type_id,  em.department_id, em.section_id, em.shift_id, em.designation_id,
                        CASE
                            WHEN bs.based_on = 'gross' THEN
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE round(es.gross_salary * (bs.amount/100))
                                END)
                            WHEN bs.based_on = 'basic' THEN
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE round(es.basic_salary * (bs.amount/100))
                                END)
                            ELSE
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE 0
                                END)
                        END AS bonus_amount, ? as com_id
                    FROM
                        bonus_settings bs
                        JOIN employees em ON bs.employee_id = em.id
                        JOIN employee_salaries es ON bs.employee_id = es.employee_id
                    WHERE
                        JSON_SEARCH(bs.bonus_id, 'one', ?) IS NOT NULL
                        AND (JSON_SEARCH(?, 'one', bs.employee_id) IS NOT NULL or ? is NULL)
                        AND TIMESTAMPDIFF(MONTH, DATE_FORMAT(CONCAT(DATE_FORMAT(em.join_date, '%Y-%m'), '-01'), '%Y-%m-%d'), ?) > bs.applicable_after
                ", [$processed_bonus->id, Bonus::find($request->bonus_id)?->name, Auth::user()?->com_id, $request->bonus_id, json_encode($request->employee_id), $request->employee_id ? json_encode($request->employee_id) : $request->employee_id, $request->date]);
            // });
            return redirect()->route('bonus-process.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('process-bonus-show');
        if ($id) {
            $processed_bonus = ProcessedBonus::findOrFail($id)->load('processedBonusDetails');
            return view('hr::bonus-process.details', compact('processed_bonus'));
        } else {
            return redirect()->route('bonus_process.index')->with('warning', 'You are trying to access wrong url');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('process-bonus-edit');
        // return view('hr::edit');
        $formType = 'edit';
        $bonuses = Bonus::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $processed_bonus = ProcessedBonus::findOrFail($id);
        $employees = Employee::where('department_id', $processed_bonus->processedBonusDetails?->first()?->employee?->department_id)->orderBy('emp_name')->pluck(DB::raw("CONCAT(emp_name, '  -  ', emp_code) AS emp_name"), 'id');

        $processed_bonus->employee_id = json_encode($processed_bonus->processedBonusDetails->pluck('employee_id'));
        // dd($processed_bonus);

        return view('hr::bonus-process.create', compact('formType', 'bonuses', 'departments', 'processed_bonus', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('process-bonus-edit');
        try {
            $request->validate([
                'date' => 'required',
                'bonus_id' => 'required',
                'department_id' => 'required',

            ]);

            $processed_bonus = ProcessedBonus::findOrFail($id);

            $processed_bonus_info = $request->only('bonus_id', 'date');

            DB::transaction(function () use ($processed_bonus_info, $request, $processed_bonus) {

                $processed_bonus->update($processed_bonus_info);
                $processed_bonus->processedBonusDetails()->delete();

                DB::insert("
                    INSERT INTO processed_bonus_details (employee_id, processed_bonus_id, bonus_name, employee_type_id, department_id, section_id, shift_id, designation_id, bonus_amount, com_id)
                    SELECT
                        es.employee_id,
                        ? as processed_bonus_id,
                        ? as bonus_name,
                        em.employee_type_id,  em.department_id, em.section_id, em.shift_id, em.designation_id,
                        CASE
                            WHEN bs.based_on = 'gross' THEN
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE round(es.gross_salary * (bs.amount/100))
                                END)
                            WHEN bs.based_on = 'basic' THEN
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE round(es.basic_salary * (bs.amount/100))
                                END)
                            ELSE
                                (CASE
                                    WHEN bs.amount_type = 'flat' THEN round(bs.amount)
                                    ELSE 0
                                END)
                        END AS bonus_amount, ? as com_id
                    FROM
                        bonus_settings bs
                        JOIN employees em ON bs.employee_id = em.id
                        JOIN employee_salaries es ON bs.employee_id = es.employee_id
                    WHERE
                        JSON_SEARCH(bs.bonus_id, 'one', ?) IS NOT NULL
                        AND (JSON_SEARCH(?, 'one', bs.employee_id) IS NOT NULL or ? is NULL)
                        AND TIMESTAMPDIFF(MONTH, DATE_FORMAT(CONCAT(DATE_FORMAT(em.join_date, '%Y-%m'), '-01'), '%Y-%m-%d'), ?) > bs.applicable_after
                ", [$processed_bonus->id, Bonus::find($request->bonus_id)?->name, Auth::user()?->com_id, $request->bonus_id, json_encode($request->employee_id), $request->employee_id ? json_encode($request->employee_id) : $request->employee_id, $request->date]);
            });

            return redirect()->route('bonus-process.index')->with('message', 'Data has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('process-bonus-delete');
        try {
            $processed_bonus = ProcessedBonus::findOrFail($id);
            $processed_bonus->processedBonusDetails()->delete();
            $processed_bonus->delete();
            return redirect()->route('bonus-process.index')->with('message', 'Processed Bonus Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
