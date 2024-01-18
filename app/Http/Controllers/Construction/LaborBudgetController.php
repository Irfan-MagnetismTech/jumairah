<?php

namespace App\Http\Controllers\Construction;

use App\Billing\ConstructionBill;
use App\Construction\ConsLaborBudget;
use App\Http\Controllers\Controller;
use App\Http\Requests\Construction\ConsLaborBudgetRequest;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaborBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:construction-labor-budget-view|construction-labor-budget-create|construction-labor-budget-edit|construction-labor-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:construction-labor-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:construction-labor-budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:construction-labor-budget-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the year.
     *
     * @return \Illuminate\Http\Response
     */
    public function yearList()
    {
        $construction_bill_data = ConstructionBill::orderBy('year', 'desc')->get();
        $years = $construction_bill_data->groupBy('year')->all();
        return view('construction.labor-budget.yearList', compact(   'years'));
    }

    /**
     * Display a listing of the month.
     *
     * @return \Illuminate\Http\Response
     */
    public function monthList($year)
    {
        $yearWise_construction_bill_data = ConstructionBill::where('year', $year)->orderBy('month', 'desc')->get();
        $months = $yearWise_construction_bill_data->groupBy('month')->all();
        return view('construction.labor-budget.monthList', compact(   'months'));
    }



    public function budgetDetails($year, $month){

        $details = ConstructionBill::with('project', 'supplier')
        ->where('year', $year)
        ->where('month', $month)
        ->orderBy('id', 'desc')
        ->get();
        $budget_details = $details->groupBy('project_id')->all();
        $project_id = [];
        foreach($budget_details as $key => $budget){
            array_push($project_id, $key);
        }
        $project_data = Project::whereNotIn('id', $project_id)->get();
        return view('construction.labor-budget.index', compact(   'budget_details', 'project_data', 'year', 'month'));
    }


    /**
     * pdf for specific month of a year.
     *
     * @param  int  $year $month
     * @return \Illuminate\Http\Response
     */
    public function pdf($year, $month)
    {
        $details = ConstructionBill::with('project', 'supplier')
        ->where('year', $year)
        ->where('month', $month)
        ->orderBy('id', 'desc')
        ->get();
        $budget_details = $details->groupBy('project_id')->all();
        $project_id = [];
        foreach($budget_details as $key => $budget){
            array_push($project_id, $key);
        }
        $project_data = Project::whereNotIn('id', $project_id)->get();
        return \PDF::loadview('construction.labor-budget.pdf', compact('budget_details', 'project_data',))->setPaper('a4', 'landscape')->stream('labor-budget.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsLaborBudget $labor_budget)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsLaborBudgetRequest $request, ConsLaborBudget $labor_budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     *  Formats the date into Y.
     *
     * @return string
     */
    private function formatYear(string $date): string
    {
        return substr(date_format(date_create($date), "Y"), 0);
    }

    /**
     *  Formats the date into m.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr(date_format(date_create($date), "m"), 0);
    }

}
