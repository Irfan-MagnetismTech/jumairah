<?php

namespace App\Http\Controllers;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\Http\Requests\BalanceAndIncomeLineRequest;
use App\LedgerEntry;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceAndIncomeLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lines = BalanceAndIncomeLine::latest()->get();
        return view('accounts.balance-income-lines.index', compact('lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_lines = BalanceAndIncomeLine::pluck('line_text', 'id');
        $line_types = ['base_header' =>'base_header','balance_header' =>'balance_header','income_header' =>'income_header','balance_line' =>'balance_line','income_line' =>'income_line'];
        return view('accounts.balance-income-lines.create', compact('parent_lines', 'line_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BalanceAndIncomeLineRequest $request)
    {
        try {
            BalanceAndIncomeLine::create($request->all());
            return redirect()->route('balance-and-income-lines.create')->with('message', 'Data has been inserted successfully');
        }
        catch (QueryException $e){
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accounts\BalanceAndIncomeLine  $balanceAndIncomeLine
     * @return \Illuminate\Http\Response
     */
    public function show(BalanceAndIncomeLine $balanceAndIncomeLine)
    {
        //dd($balanceAndIncomeLine);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accounts\BalanceAndIncomeLine  $balanceAndIncomeLine
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $balanceAndIncomeLine = BalanceAndIncomeLine::where('id', $id)->first();
        $parent_lines = BalanceAndIncomeLine::pluck('line_text', 'id');
        $line_types = ['base_header' =>'base_header','balance_header' =>'balance_header','income_header' =>'income_header','balance_line' =>'balance_line','income_line' =>'income_line'];
        return view('accounts.balance-income-lines.create', compact('parent_lines', 'line_types', 'balanceAndIncomeLine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accounts\BalanceAndIncomeLine  $balanceAndIncomeLine
     * @return \Illuminate\Http\Response
     */
    public function update(BalanceAndIncomeLineRequest $request, BalanceAndIncomeLine $balanceAndIncomeLine)
    {
        try {
            $balanceAndIncomeLine->update($request->all());
           return redirect()->route('balance-and-income-lines.index')->with('message', 'Data has been Updated successfully');
       }catch (\Exception $e)
       {
           return redirect()->back()->withInput()->with('error', $e->getMessage());
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accounts\BalanceAndIncomeLine  $balanceAndIncomeLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(BalanceAndIncomeLine $balanceAndIncomeLine)
    {
        try {
            $balanceAndIncomeLine->delete();
            return redirect()->route('balance-and-income-lines.index')->with('message', 'Data has been Deleted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



}
