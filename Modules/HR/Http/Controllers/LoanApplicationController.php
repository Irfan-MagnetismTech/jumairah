<?php

namespace Modules\HR\Http\Controllers;

use App\Accounts\Account;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\LoanApplication;
use App\Http\Controllers\AccountController;
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
            $loan = LoanApplication::create($input);

            $accountChk = Account::where('accountable_type', LoanApplication::class)
                ->where('balance_and_income_line_id', 9)
                ->where('account_name', $loan->employee->emp_name)
                ->first();

            if (!$accountChk) {
                $loan->account()->create([
                    'account_name' => $loan->employee->emp_name,
                    'account_type' => 2,
                    'account_code' => (new AccountController)->AccountsRefGeneratorBackendUse(9),
                    'balance_and_income_line_id' => 9,
                    'parent_account_id' => null,
                ]);
            }


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

            $loanApplication->account->update([
                'account_name' => $loanApplication->employee->emp_name,
            ]);
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
            if ($loanApplication->account) {
                $loanApplication->account->delete();
            }
            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Appliaction deleted Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-applications.index')->withInput()->withErrors($e->getMessage());
        }
    }

    public function loanApprove($id)
    {

        $loanApplication = LoanApplication::findOrFail($id);

        $loanApplication->update([
            'loan_status' => 'approved',
            'approved_by' => Auth::user()->id,
            'approved_date' => Carbon::now(),
        ]);

        return redirect()->route('loan-applications.index')->with('message', 'Loan Appliaction Approved Successfully.');
    }

    public function loanPaymentStore(Request $request)
    {
        try {
            $input = $request->all();
            DB::beginTransaction();
            $loanApplication = LoanApplication::findOrFail($input['loan_application_id']);
            $loanApplication->update([
                'left_amount' => $input['loan_amount'],
                'loan_released_date' => $input['date'],
                'loan_released_by' => Auth::user()->id,
            ]);

            // accounts voucher entry

            $transactionData = [
                'voucher_type' => 'Journal',
                'bill_no' => null,
                'mr_no' => null,
                'transaction_date' => Carbon::createFromFormat('Y-m-d', $input['date'])->format('d-m-Y'),
                'narration' => 'loan released to ' . $loanApplication->employee->emp_name,
                'user_id' => auth()->id(),
            ];

            $transaction = $loanApplication->transaction()->create($transactionData);

            $employeeLoanAccount = Account::where('accountable_type', LoanApplication::class)
                ->where('balance_and_income_line_id', 9)
                ->where('account_name', $loanApplication->employee->emp_name)
                ->first();

            $emoloyeeLoanAccountLedgerData = [
                'account_id' => $employeeLoanAccount->id,
                'dr_amount' => $input['loan_amount'],
                'pourpose' => 'loan released to ' . $loanApplication->employee->emp_name,
            ];

            $paymentAccount = Account::where('id', $input['payment_account'])->first();

            $paymentAccountLedgerData = [
                'account_id' =>  $paymentAccount->id,
                'cr_amount' => $input['loan_amount'],
                'remarks' => 'loan released to ' . $loanApplication->employee->emp_name,
            ];

            $transaction->ledgerEntries()->createMany([$emoloyeeLoanAccountLedgerData, $paymentAccountLedgerData]);
            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Released Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-applications.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
