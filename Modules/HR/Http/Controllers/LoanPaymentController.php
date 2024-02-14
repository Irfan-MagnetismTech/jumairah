<?php

namespace Modules\HR\Http\Controllers;

use App\Accounts\Loan;
use App\Accounts\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\LoanPayment;
use Illuminate\Database\QueryException;
use Modules\HR\Entities\LoanApplication;
use Illuminate\Contracts\Support\Renderable;

class LoanPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $loanPayments = LoanPayment::with('loan_application.employee', 'loan_application.loan_type')->latest()->get();
        return view('hr::loan-payment.index', compact('loanPayments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {

        $formType = 'create';
        $loanApplication = LoanApplication::with('employee', 'loan_type')->find($id);
        return view('hr::loan-payment.create', compact('formType', 'loanApplication'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->only('loan_application_id', 'payment_amount', 'payment_date');
            $loanApplication = LoanApplication::find($input['loan_application_id']);
            $loanApplication->left_amount -= $input['payment_amount'];
            $loanApplication->save();
            $input['created_by'] = auth()->user()->id;
            $loanPayment = LoanPayment::create($input);

            DB::commit();
            return redirect()->route('loan-applications.index')->with('message', 'Loan Payment created Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-payments.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $loan_payment = LoanPayment::findOrFail($id);
        $formType = 'edit';
        return view('hr::loan-payment.create', compact('loan_payment', 'formType'));
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
            DB::beginTransaction();
            $input = $request->only('loan_application_id', 'payment_amount', 'payment_date');
            $loanPayment = LoanPayment::find($id);
            $loanPayment->update($input);
            DB::commit();
            return redirect()->route('loan-payments.index')->with('message', 'Loan Payment updated Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-payments.edit')->withInput()->withErrors($e->getMessage());
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
            DB::beginTransaction();
            $loanPayment = LoanPayment::findOrFail($id);
            $loanApplication = LoanApplication::find($loanPayment->loan_application_id);
            $loanApplication->left_amount += $loanPayment->payment_amount;
            $loanApplication->save();
            $loanPayment->delete();
            DB::commit();
            return redirect()->route('loan-payments.index')->with('message', 'Loan Payment deleted Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('loan-payments.index')->withErrors($e->getMessage());
        }
    }

    public function loanHandover($id)
    {
        $loan_application = LoanApplication::findOrFail($id);
        $formType = 'create';
        $accounts = Account::pluck('account_name', 'id');
        return view('hr::loan-application.loan-handover-form', compact('loan_application', 'formType', 'accounts'));
    }
}
