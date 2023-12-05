<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BD\BdBudgetRequest;
use App\BD\BdBudget;
use App\Config\BudgetHead;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;



class BdBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-monthly-budget-view|bd-monthly-budget-create|bd-monthly-budget-edit|bd-monthly-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-monthly-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-monthly-budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-monthly-budget-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the year.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_budget_data = BdBudget::orderBy('year', 'desc')->get();
        $years = $bd_budget_data->groupBy('year')->all();
        return view('bd.budget.index', compact('years'));
    }

    /**
     * Display a listing of the monthList.
     *
     * @return \Illuminate\Http\Response
     */
    public function BdBudgetList($year)
    {
        $months = BdBudget::where('year', $year)->orderBy('month', 'desc')->get();
        return view('bd.budget.budget-list', compact('months'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $particulars = BudgetHead::get();
        return view('bd.budget.create', compact('formType', 'particulars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdBudgetRequest $request)
    {
        try{
            $bd_budget_data                     = $request->only('applied_date', 'progress_total_amount', 'future_total_amount');
            $bd_budget_data['total_amount']     = $request->progress_total_amount + $request->future_total_amount;
            $bd_budget_data['year']             = $this->formatYear($request->applied_date);
            $bd_budget_data['month']            = $this->formatMonth($request->applied_date);
            $bd_budget_data['entry_by']         = auth()->id();

            $bd_progress_budget_details = [];
            foreach($request->progress_cost_center_id as $key => $data)
            {
                $bd_progress_budget_details[] = [
                    'progress_cost_center_id'   =>  $request->progress_cost_center_id[$key],
                    'progress_particulers'      =>  $request->progress_particulers[$key],
                    'progress_amount'           =>  $request->progress_amount[$key],
                    'progress_remarks'          =>  $request->progress_remarks[$key]
                ];
            }


            $bd_future_budget_details = [];
            foreach($request->future_cost_center_id as $key => $data)
            {
                $bd_future_budget_details[] = [
                    'future_cost_center_id'     =>  $request->future_cost_center_id[$key],
                    'future_particulers'        =>  $request->future_particulers[$key],
                    'future_amount'             =>  $request->future_amount[$key],
                    'future_remarks'            =>  $request->future_remarks[$key]
                ];
            }

            DB::transaction(function()use($bd_budget_data, $bd_progress_budget_details, $bd_future_budget_details){
                $bd_lead_generation = BdBudget::create($bd_budget_data);
                $bd_lead_generation->BdProgressBudget()->createMany($bd_progress_budget_details);
                $bd_lead_generation->BdFutureBudget()->createMany($bd_future_budget_details);
            });

            return redirect()->route('bd_budget.create')->with('message', 'Budget has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bd_budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BdBudget $bd_budget)
    {
        $formType = "edit";
        $particulars = BudgetHead::get();
        return view('bd.budget.create', compact('formType', 'bd_budget','particulars'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdBudgetRequest $request, BdBudget $bd_budget)
    {
        try{
            $bd_budget_data                     = $request->only('applied_date', 'progress_total_amount', 'future_total_amount');
            $bd_budget_data['total_amount']     = $request->progress_total_amount + $request->future_total_amount;
            $bd_budget_data['year']             = $this->formatYear($request->applied_date);
            $bd_budget_data['month']            = $this->formatMonth($request->applied_date);
            $bd_budget_data['entry_by']         = auth()->id();

            $bd_progress_budget_details = [];
            foreach($request->progress_cost_center_id as $key => $data)
            {
                $bd_progress_budget_details[] = [
                    'progress_cost_center_id'   =>  $request->progress_cost_center_id[$key],
                    'progress_particulers'      =>  $request->progress_particulers[$key],
                    'progress_amount'           =>  $request->progress_amount[$key],
                    'progress_remarks'          =>  $request->progress_remarks[$key]
                ];
            }


            $bd_future_budget_details = [];
            foreach($request->future_cost_center_id as $key => $data)
            {
                $bd_future_budget_details[] = [
                    'future_cost_center_id'     =>  $request->future_cost_center_id[$key],
                    'future_particulers'        =>  $request->future_particulers[$key],
                    'future_amount'             =>  $request->future_amount[$key],
                    'future_remarks'            =>  $request->future_remarks[$key]
                ];
            }

            DB::transaction(function()use($bd_budget, $bd_budget_data, $bd_progress_budget_details, $bd_future_budget_details){
                $bd_budget->update($bd_budget_data);
                $bd_budget->BdProgressBudget()->delete();
                $bd_budget->BdFutureBudget()->delete();
                $bd_budget->BdProgressBudget()->createMany($bd_progress_budget_details);
                $bd_budget->BdFutureBudget()->createMany($bd_future_budget_details);
            });

            return redirect()->route('bd_budget.index')->with('message', 'Budget has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdBudget $bd_budget)
    {
        try{
            $bd_budget->delete();
            return redirect()->route('bd_budget.index')->with('message', 'Budget has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bd_budget.index')->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $bd_budget_details = BdBudget::where('id', $id)->get();
        return \PDF::loadview('bd.budget.pdf', compact('bd_budget_details'))->setPaper('A4', 'portrait')->stream('bd.budget.pdf');
    }


    /**
     *  Formats the date into y.
     *
     * @return string
     */
    private function formatYear(string $date): string
    {
        return substr( date_format(date_create($date),"y"), 0);
    }

    /**
     *  Formats the date into m.
     *
     * @return string
     */
    private function formatMonth(string $date): string
    {
        return substr( date_format(date_create($date),"m"), 0);
    }


    public function PasswordChange(){
        $data = "ok";
        return view('auth.passwords.password-change', compact('data'));
    }
}
