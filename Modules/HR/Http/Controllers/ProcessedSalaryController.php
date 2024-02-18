<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use App\CostCenter;
use App\Department;
use App\Transaction;
use App\Accounts\Account;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\ProcessedSalary;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProcessedSalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $this->authorize('show-processed-salary');
        $month = $request->filter_month;
        $department_id = $request->filter_department_id;
        $cost_center_id = $request->filter_cost_center_id;

        $processed_salaries =
            ProcessedSalary::when($month, function ($query) use ($month) {
                return $query->where('month', $month);
            })
            ->when($department_id, function ($query) use ($department_id) {
                return $query->where('department_id', $department_id);
            })
            ->when($cost_center_id, function ($query) use ($cost_center_id) {
                return $query->where('cost_center_id', $cost_center_id);
            })
            ->with('employee.department')->latest()
            ->paginate($request->per_page ?? 15)
            ->withQueryString();

        $departments = Department::orderBy('name')->pluck('name', 'id');
        // dd($processed_salaries);
        $costCenters = CostCenter::orderBy('name')->pluck('name', 'id');
        return view('hr::salary.index_processed', compact('processed_salaries', 'departments', 'costCenters'));
    }

    public function processedSalary(Request $request)
    {
        $this->authorize('process-salary');

        // $com_user_id = Auth::user()->com_id;
        $cost_center_id = $request->cost_center_id;
        $department_id = $request->department_id;
        $month = $request->month;

        try {
            DB::select(
                "SET @month = ?, @Department = ?, @CostCenter = ?",
                [$month, $department_id, $cost_center_id]
            );
            DB::select("CALL salary_processed(@month,@Department,@CostCenter)");

            $AllProcessedSalary = ProcessedSalary::where('month', $month)
                ->where('department_id', $department_id)
                ->where('cost_center_id', $cost_center_id)
                ->get();

            // total salary calculation

            $total_salary = 0;

            $total_working_amount = $AllProcessedSalary->sum('total_working_amount');
            $total_ot_amount = $AllProcessedSalary->sum('total_ot_amount');
            $adjustment_amount = $AllProcessedSalary->sum('adjustment_amount');
            $house_rent = $AllProcessedSalary->sum('house_rent');
            $medical_allowance = $AllProcessedSalary->sum('medical_allowance');
            $tansport_allowance = $AllProcessedSalary->sum('tansport_allowance');
            $food_allowance = $AllProcessedSalary->sum('food_allowance');
            $other_allowance = $AllProcessedSalary->sum('other_allowance');
            $mobile_allowance = $AllProcessedSalary->sum('mobile_allowance');
            $grade_bonus = $AllProcessedSalary->sum('grade_bonus');
            $skill_bonus = $AllProcessedSalary->sum('skill_bonus');
            $management_bonus = $AllProcessedSalary->sum('management_bonus');
            $income_tax = $AllProcessedSalary->sum('income_tax');


            if ($AllProcessedSalary->sum('casual_salary') > 0) {
                $total_salary += $AllProcessedSalary->sum('casual_salary');
            }

            $total_salary += $total_working_amount + $total_ot_amount + $adjustment_amount + $house_rent + $medical_allowance + $tansport_allowance + $food_allowance + $other_allowance + $mobile_allowance + $grade_bonus + $skill_bonus + $management_bonus - $income_tax;




            if (count($AllProcessedSalary) > 0) {

                $transactionData = [
                    'voucher_type' => 'Journal',
                    'transactionable_type' => ProcessedSalary::class,
                    'transactionable_id' => $AllProcessedSalary[0]->id,
                    'bill_no' => null,
                    'mr_no' => null,
                    'transaction_date' => Carbon::now()->format('d-m-Y'),
                    'narration' => 'salary',
                    'user_id' => auth()->id(),
                ];

                $transaction = Transaction::create($transactionData);

                // ledger entry

                $SalaryAllowanceAndBenefits = Account::where('balance_and_income_line_id', 86)->where('account_name', 'Salary, Allowances & Benefits')->first();
                    $AdminSalaryLedgerData = [
                        'account_id' => $SalaryAllowanceAndBenefits->id,
                        'dr_amount' => $total_salary,
                        'cost_center_id' => $cost_center_id,
                        'remarks' => 'salary',
                        'purpose' => 'administrative salary expense',
                        'balance_and_income_line_id' => $SalaryAllowanceAndBenefits->balance_and_income_line_id,
                    ];
                    $transaction->ledgerEntries()->create($AdminSalaryLedgerData);
            }

            return redirect()->route(
                'process-salary.index',
                [
                    'filter_month' => $month,
                    'filter_department_id' => $department_id,
                    'filter_cost_center_id' => $cost_center_id
                ]
            )->with('message', 'Salary Processed Successfully');
        } catch (QueryException $e) {
            dd($e);
            return redirect()->route('process-salary.index')->with('error', $e);
        }
    }
}
