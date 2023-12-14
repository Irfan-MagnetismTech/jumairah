<?php

namespace App\Http\Controllers;

use App\CashFlowLine;
use Illuminate\Http\Request;

class CashFlowLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lines = CashFlowLine::latest()->paginate(100);
        return view('accounts.cash-flow-lines.index', compact('lines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_lines = CashFlowLine::pluck('line_text', 'id');
        $line_types = ['header' => 'header','line' =>'line'];
        $balanceTypes = ['total','per_period','D','C'];
        return view('accounts.cash-flow-lines.create', compact('parent_lines', 'line_types', 'balanceTypes'));
    }

    public function store(Request $request)
    {
        try {
            CashFlowLine::create($request->all());
            return redirect()->route('cash-flow-lines.index');
        }
        catch (\Exception $e){
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(CashFlowLine $cashFlowLine)
    {
        //
    }

    public function edit(CashFlowLine $cashFlowLine)
    {
        $parent_lines = CashFlowLine::pluck('line_text', 'id');
        $line_types = ['header' => 'header','line' =>'line'];
        $balanceTypes = ['total','per_period','D','C'];
        return view('accounts.cash-flow-lines.create', compact('parent_lines', 'line_types', 'balanceTypes', 'cashFlowLine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashFlowLine  $cashFlowLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashFlowLine $cashFlowLine)
    {
        try {
            $cashFlowLine->update($request->all());
           return redirect()->route('cash-flow-lines.index');
       }catch (\Exception $e)
       {
           return redirect()->back()->withInput()->with('error', $e->getMessage());
       };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashFlowLine  $cashFlowLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashFlowLine $cashFlowLine)
    {
        try {
            $cashFlowLine->delete();
            return redirect()->route('accounts.cash-flow-lines.index');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        };
    }
}
