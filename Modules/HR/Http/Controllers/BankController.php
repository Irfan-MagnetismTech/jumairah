<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Bank;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Accounting\Entities\Account;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $banks = Bank::latest()->get();
        return view('hr::bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        return view('hr::bank.create', compact('formType'));
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

            $input = $request->all();

            $bank =  Bank::create($input);

            // createAccountHelper($bank->name, 1, 8, null);
            $bank->account()->create([
                'account_name' => $bank->name,
                'account_type' => 1,
                'balance_and_income_line_id' => 8,
                'parent_account_id' => null,
            ]);
            DB::commit();


            return redirect()->route('banks.index')->with('message', 'bank information created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('banks.index')->withInput()->withErrors($e->getMessage());
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
        $formType = "edit";
        $bank = Bank::findOrFail($id);
        return view('hr::bank.create', compact('formType', 'bank'));
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
            $input = $request->all();
            DB::transaction(function () use ($input, $request, $id) {
                $bank = Bank::findOrFail($id);
                $bank->update($input);

                // Update Bank Account
                Account::where([
                    'balance_and_income_line_id' => 8,
                    'accountable_type' => Bank::class,
                    'accountable_id' => $bank->id,
                ])->update(['account_name' => $bank->name]);
            });

            return redirect()->route('banks.index')->with('message', 'bank information updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('banks.edit')->withInput()->withErrors($e->getMessage());
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
            $message = 0;
            DB::transaction(function () use ($id, &$message) {
                $bank = Bank::with('employeeBankInfo', 'employee_bank_info')->findOrFail($id);
                // dd($bank);
                if ($bank->employeeBankInfo->count() === 0 && $bank->employee_bank_info->count() === 0) {
                    $bank->delete();
                    Account::where(['accountable_type' => Bank::class, 'accountable_id' => $id])->delete();
                    $message = ['message' => 'Bank information deleted successfully.'];
                } else {
                    $message = ['error' => 'This data has some dependency.'];
                }
            });

            return redirect()->route('banks.index')->with($message);
        } catch (QueryException $e) {
            return redirect()->route('banks.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
