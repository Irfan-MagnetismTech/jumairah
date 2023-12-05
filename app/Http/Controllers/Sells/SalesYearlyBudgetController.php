<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesYearlyBudgetRequest;
use App\Sells\SalesYearlyBudget;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesYearlyBudgetController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:sales-yearly-budget-view|sales-yearly-budget-create|sales-yearly-budget-edit|sales-yearly-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sales-yearly-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:sales-yearly-budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sales-yearly-budget-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $budgets = SalesYearlyBudget::latest()->get();
        return view('sales/sales-yearly-budgets/index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.sales-yearly-budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesYearlyBudgetRequest $request)
    {
        try {
            $data = $request->only('project_id','year');
            $data['user_id'] = auth()->user()->id;
            $detailsArray = array();
            foreach ($request->month as  $key => $detail) {
                $detailsArray[] = [
                    'month'            =>  $request->month[$key],
                    'sales_value'      =>  $request->sales_value[$key],
                    'booking_money'    =>  $request->booking_money[$key],
                ];
            }
//            dd($request->all(), $data);
            DB::transaction(function() use ($detailsArray, $data) {
                $salesYearlyBudget = SalesYearlyBudget::create($data);
                $salesYearlyBudget->salesYearlyBudgetDetails()->createMany($detailsArray);
            });
            return redirect()->route('sales-yearly-budgets.index')->with('message', 'Budget has been added successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesYearlyBudget  $salesYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function show(SalesYearlyBudget $salesYearlyBudget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesYearlyBudget  $salesYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesYearlyBudget $salesYearlyBudget)
    {
        return view('sales.sales-yearly-budgets.create', compact('salesYearlyBudget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesYearlyBudget  $salesYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function update(SalesYearlyBudgetRequest $request, SalesYearlyBudget $salesYearlyBudget)
    {
        try {
            $data = $request->only('project_id','year');
            $data['user_id'] = auth()->user()->id;
            $detailsArray = array();
            foreach ($request->month as  $key => $detail) {
                $detailsArray[] = [
                    'month'            =>  $request->month[$key],
                    'sales_value'      =>  $request->sales_value[$key],
                    'booking_money'    =>  $request->booking_money[$key],
                ];
            }
            DB::transaction(function() use ($detailsArray, $data, $salesYearlyBudget) {
                $salesYearlyBudget->update($data);
                $salesYearlyBudget->salesYearlyBudgetDetails()->delete();
                $salesYearlyBudget->salesYearlyBudgetDetails()->createMany($detailsArray);
            });
            return redirect()->route('sales-yearly-budgets.index')->with('message', 'Budget has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesYearlyBudget  $salesYearlyBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesYearlyBudget $salesYearlyBudget)
    {
        try {
            $salesYearlyBudget->delete($salesYearlyBudget);
            return redirect()->route('sales-yearly-budgets.index')->with('message', 'Budget has been Deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
