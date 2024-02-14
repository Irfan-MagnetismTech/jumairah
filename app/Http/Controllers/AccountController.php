<?php

namespace App\Http\Controllers;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\CogsGroup;
use App\Http\Requests\AccountRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::with('balanceIncome', 'parent')->latest()->get();
        return view('accounts.accounts.index', compact('accounts'));
    }

    public function accountList()
    {
        $balanceIncomeHeaders = BalanceAndIncomeLine::whereIn('line_type', ['income_header', 'balance_header'])
            ->get();
        //        $accounts = Account::whereNull('parent_account_id')->get();
        //        dd($balanceIncomeHeaders);
        return view('accounts.accounts.accountList', compact('balanceIncomeHeaders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentAccounts = [];
        $groups = CogsGroup::pluck('name', 'id');
        $balanceIncomeLines = BalanceAndIncomeLine::whereIn('line_type', ['balance_line', 'income_line'])->orderBy('line_text')->pluck('line_text', 'id');
        $accountTypes = [1 => 'Assets', 2 => 'Liabilities', 3 => 'Equity', 4 => 'Revenues', 5 => 'Expenses'];
        return view('accounts.accounts.create', compact('balanceIncomeLines', 'accountTypes', 'parentAccounts', 'groups'));
    }

    public function store(AccountRequest $request)
    {
        try {
            $data = $request->all();
            $data['account_name'] = $request->account_name;
            Account::create($data);
            return redirect()->route('accounts.create')->with('message', 'Data has been Inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accounts\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    public function edit(Account $account)
    {
        $groups = CogsGroup::pluck('name', 'id');
        $parentAccounts = Account::orderBy('account_name')->where('balance_and_income_line_id', $account->balance_and_income_line_id)->pluck('account_name', 'id');
        $balanceIncomeLines = BalanceAndIncomeLine::whereIn('line_type', ['balance_line', 'income_line'])->orderBy('line_text')->pluck('line_text', 'id');
        $accountTypes = [1 => 'Assets', 2 => 'Liabilities', 3 => 'Equity', 4 => 'Revenues', 5 => 'Expenses'];

        return view('accounts.accounts.create', compact('balanceIncomeLines', 'accountTypes', 'parentAccounts', 'account', 'groups'));
    }

    public function update(AccountRequest $request, Account $account)
    {
        try {
            $data = $request->all();
            $account->update($data);
            return redirect()->route('accounts.index')->with('message', 'Data has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Account $account)
    {
        try {
            $account->delete();
            return redirect()->route('accounts.index')->with('message', 'Data has been Deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function AccountsRefGenerator($balanceIncomeLineId)
    {
        $currentAccountCode = null;
        $balanceid = BalanceAndIncomeLine::where('id', $balanceIncomeLineId)->firstOrFail()->ancestors->pluck('id')->implode('-');
        $lastAccount = Account::where('account_code', "LIKE", "$balanceid-$balanceIncomeLineId-%")->latest()->first();

        //        dd($balanceid,$lastAccount);
        if (!empty($lastAccount)) {
            list(,,, $aad) = explode("-", $lastAccount->account_code);
            $currentAccountCode = $aad + 1;
        } else {
            $currentAccountCode = 1;
        }
        //        dd($currentAccountCode);
        return json_encode("$balanceid-$balanceIncomeLineId-$currentAccountCode");
    }

    public function AccountsRefGeneratorBackendUse($balanceIncomeLineId)
    {
        $currentAccountCode = null;
        $balanceid = BalanceAndIncomeLine::where('id', $balanceIncomeLineId)->firstOrFail()->ancestors->pluck('id')->implode('-');
        $lastAccount = Account::where('account_code', "LIKE", "$balanceid-$balanceIncomeLineId-%")->latest()->first();
        if (!empty($lastAccount)) {
            list(,,, $aad) = explode("-", $lastAccount->account_code);
            $currentAccountCode = $aad + 1;
        } else {
            $currentAccountCode = 1;
        }
        $account_code =  $balanceid . '-' . $balanceIncomeLineId . '-' . $currentAccountCode;

        return $account_code;
    }

    public function accountsRefCode($accountId)
    {
        $balanceIncomeLineData = Account::where('id', $accountId)->first();
        $balanceIncomeLineId = $balanceIncomeLineData->balance_and_income_line_id;
        $currentAccountCode = null;
        $balanceid = BalanceAndIncomeLine::where('id', $balanceIncomeLineId)->first()->ancestors->pluck('id')->implode('-');
        $lastAccount = Account::where('account_code', "LIKE", "$balanceid-$balanceIncomeLineId-%")->latest()->first();

        if (!empty($lastAccount)) {
            list(,,, $aad) = explode("-", $lastAccount->account_code);
            $currentAccountCode = $aad + 1;
        } else {
            $currentAccountCode = 1;
        }
        return json_encode("$balanceid-$balanceIncomeLineId-$currentAccountCode");
    }
}
