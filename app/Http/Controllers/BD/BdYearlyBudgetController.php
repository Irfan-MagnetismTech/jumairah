<?php

namespace App\Http\Controllers\BD;

use App\BD\BdYearlyBudget;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdYearlyBudgetRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BdYearlyBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-yearly-budget-view|bd-yearly-budget-create|bd-yearly-budget-edit|bd-yearly-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-yearly-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-yearly-budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-yearly-budget-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_yearly_budget_data = BdYearlyBudget::orderBy('year', 'desc')->get();
        return view('bd.yearly-budget.index', compact('bd_yearly_budget_data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('bd.yearly-budget.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdYearlyBudgetRequest $request)
    {
        try{
            $bd_yearly_budget_data                     = $request->only('applied_date', 'progress_total_amount', 'future_total_amount');
            $bd_yearly_budget_data['total_amount']     = $request->progress_total_amount + $request->future_total_amount;
            $bd_yearly_budget_data['year']             = $this->formatYear($request->applied_date);
            $bd_yearly_budget_data['entry_by']         = auth()->id();

            $bd_progress_yearly_budget_details = [];
            foreach($request->progress_cost_center_id as $key => $data)
            {
                $bd_progress_yearly_budget_details[] = [
                    'progress_cost_center_id'   =>  $request->progress_cost_center_id[$key],
                    'progress_particulers'      =>  $request->progress_particulers[$key],
                    'progress_amount'           =>  $request->progress_amount[$key],
                    'progress_january'          =>  $request->progress_january[$key],
                    'progress_february'         =>  $request->progress_february[$key],
                    'progress_march'            =>  $request->progress_march[$key],
                    'progress_april'            =>  $request->progress_april[$key],
                    'progress_may'              =>  $request->progress_may[$key],
                    'progress_june'             =>  $request->progress_june[$key],
                    'progress_july'             =>  $request->progress_july[$key],
                    'progress_august'           =>  $request->progress_august[$key],
                    'progress_september'        =>  $request->progress_september[$key],
                    'progress_october'          =>  $request->progress_october[$key],
                    'progress_november'         =>  $request->progress_november[$key],
                    'progress_december'         =>  $request->progress_december[$key],
                    'progress_remarks'          =>  $request->progress_remarks[$key]
                ];
            }


            $bd_future_yearly_budget_details = [];
            foreach($request->future_cost_center_id as $key => $data)
            {
                $bd_future_yearly_budget_details[] = [
                    'future_cost_center_id'     =>  $request->future_cost_center_id[$key],
                    'future_particulers'        =>  $request->future_particulers[$key],
                    'future_amount'             =>  $request->future_amount[$key],
                    'future_january'            =>  $request->future_january[$key],
                    'future_february'           =>  $request->future_february[$key],
                    'future_march'              =>  $request->future_march[$key],
                    'future_april'              =>  $request->future_april[$key],
                    'future_may'                =>  $request->future_may[$key],
                    'future_june'               =>  $request->future_june[$key],
                    'future_july'               =>  $request->future_july[$key],
                    'future_august'             =>  $request->future_august[$key],
                    'future_september'          =>  $request->future_september[$key],
                    'future_october'            =>  $request->future_october[$key],
                    'future_november'           =>  $request->future_november[$key],
                    'future_december'           =>  $request->future_december[$key],
                    'future_remarks'            =>  $request->future_remarks[$key]
                ];
            }

            DB::transaction(function()use($bd_yearly_budget_data, $bd_progress_yearly_budget_details, $bd_future_yearly_budget_details){
                $bd_yearly_budget = BdYearlyBudget::create($bd_yearly_budget_data);
                $bd_yearly_budget->BdProgressYearlyBudget()->createMany($bd_progress_yearly_budget_details);
                $bd_yearly_budget->BdFutureYearlyBudget()->createMany($bd_future_yearly_budget_details);
            });

            return redirect()->route('bd_yearly_budget.index')->with('message', 'Budget has been inserted successfully');
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
    public function edit(BdYearlyBudget $bd_yearly_budget)
    {
        $formType = "edit";
        return view('bd.yearly-budget.create', compact('formType', 'bd_yearly_budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdYearlyBudgetRequest $request, BdYearlyBudget $bd_yearly_budget)
    {
        try{
            $bd_yearly_budget_data                     = $request->only('applied_date', 'progress_total_amount', 'future_total_amount');
            $bd_yearly_budget_data['total_amount']     = $request->progress_total_amount + $request->future_total_amount;
            $bd_yearly_budget_data['year']             = $this->formatYear($request->applied_date);
            $bd_yearly_budget_data['entry_by']         = auth()->id();

            $bd_progress_yearly_budget_details = [];
            foreach($request->progress_cost_center_id as $key => $data)
            {
                $bd_progress_yearly_budget_details[] = [
                    'progress_cost_center_id'   =>  $request->progress_cost_center_id[$key],
                    'progress_particulers'      =>  $request->progress_particulers[$key],
                    'progress_amount'           =>  $request->progress_amount[$key],
                    'progress_january'          =>  $request->progress_january[$key],
                    'progress_february'         =>  $request->progress_february[$key],
                    'progress_march'            =>  $request->progress_march[$key],
                    'progress_april'            =>  $request->progress_april[$key],
                    'progress_may'              =>  $request->progress_may[$key],
                    'progress_june'             =>  $request->progress_june[$key],
                    'progress_july'             =>  $request->progress_july[$key],
                    'progress_august'           =>  $request->progress_august[$key],
                    'progress_september'        =>  $request->progress_september[$key],
                    'progress_october'          =>  $request->progress_october[$key],
                    'progress_november'         =>  $request->progress_november[$key],
                    'progress_december'         =>  $request->progress_december[$key],
                    'progress_remarks'          =>  $request->progress_remarks[$key]
                ];
            }


            $bd_future_yearly_budget_details = [];
            foreach($request->future_cost_center_id as $key => $data)
            {
                $bd_future_yearly_budget_details[] = [
                    'future_cost_center_id'     =>  $request->future_cost_center_id[$key],
                    'future_particulers'        =>  $request->future_particulers[$key],
                    'future_amount'             =>  $request->future_amount[$key],
                    'future_january'            =>  $request->future_january[$key],
                    'future_february'           =>  $request->future_february[$key],
                    'future_march'              =>  $request->future_march[$key],
                    'future_april'              =>  $request->future_april[$key],
                    'future_may'                =>  $request->future_may[$key],
                    'future_june'               =>  $request->future_june[$key],
                    'future_july'               =>  $request->future_july[$key],
                    'future_august'             =>  $request->future_august[$key],
                    'future_september'          =>  $request->future_september[$key],
                    'future_october'            =>  $request->future_october[$key],
                    'future_november'           =>  $request->future_november[$key],
                    'future_december'           =>  $request->future_december[$key],
                    'future_remarks'            =>  $request->future_remarks[$key]
                ];
            }

            DB::transaction(function()use($bd_yearly_budget, $bd_yearly_budget_data, $bd_progress_yearly_budget_details, $bd_future_yearly_budget_details){
                $bd_yearly_budget->update($bd_yearly_budget_data);
                $bd_yearly_budget->BdProgressYearlyBudget()->delete();
                $bd_yearly_budget->BdFutureYearlyBudget()->delete();
                $bd_yearly_budget->BdProgressYearlyBudget()->createMany($bd_progress_yearly_budget_details);
                $bd_yearly_budget->BdFutureYearlyBudget()->createMany($bd_future_yearly_budget_details);
            });

            return redirect()->route('bd_yearly_budget.index')->with('message', 'Budget has been updated successfully');
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
    public function destroy(BdYearlyBudget $bd_yearly_budget)
    {
        try{
            $bd_yearly_budget->delete();
            return redirect()->route('bd_yearly_budget.index')->with('message', 'Budget has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('bd_yearly_budget.index')->withErrors($e->getMessage());
        }
    }

    public function pdf($id)
    {
        $bd_yearly_budget_details = BdYearlyBudget::where('id', $id)
        ->get();

        return \PDF::loadview('bd.yearly-budget.pdf', compact('bd_yearly_budget_details'))->setPaper('A4', 'landscape')->stream('bd-yearly-budget.pdf');
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
}
