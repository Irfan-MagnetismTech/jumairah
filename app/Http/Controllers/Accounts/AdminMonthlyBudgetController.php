<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Accounts\AdminMonthlyBudget;
use App\Config\BudgetHead;
use App\Accounts\AdminMonthlyBudgetDetail;
use App\Http\Requests\AdminMonthlyBudgetRequest;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;

class AdminMonthlyBudgetController extends Controller
{

   public function index()
    {
        $budgets = AdminMonthlyBudget::latest()->get();
        return view('admin_monthly_budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budget_heads = BudgetHead::get();
        return view('admin_monthly_budgets.create',compact('budget_heads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|unique:admin_monthly_budgets',
        ]);
        
        try {
            $add_budget = new AdminMonthlyBudget;
            $add_budget->date = Carbon::parse($request->date)->toDateString();
            $add_budget->month = $request->month;
            $add_budget->department_id = Auth::user()->department_id;
            $add_budget->user_id = Auth::user()->id;
            $add_budget->save();
            if($add_budget){
                foreach ($request->budget_head_id as  $key => $detail) {
                        $add_budget_details = new AdminMonthlyBudgetDetail;
                        $add_budget_details->budget_id = $add_budget->id;
                        $add_budget_details->budget_head_id = $request->budget_head_id[$key];
                        $add_budget_details->week_one = $request->week_one[$key];
                        $add_budget_details->week_two = $request->week_two[$key];
                        $add_budget_details->week_three = $request->week_three[$key];
                        $add_budget_details->week_four = $request->week_four[$key];
                        $add_budget_details->week_five = $request->week_five[$key];
                        $add_budget_details->remarks = $request->remarks[$key];
                        $add_budget_details->amount = $request->amount[$key];
                        $add_budget_details->save();
                    }
            }
            return redirect()->route('admin-monthly-budgets.index')->with('message', 'Budget has been added successfully');
        } catch (QueryException $e) {
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
    public function edit(AdminMonthlyBudget $adminMonthlyBudget)
    {
        $budget_heads = BudgetHead::get();
        return view('admin_monthly_budgets.create', compact('adminMonthlyBudget', 'budget_heads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminMonthlyBudgetRequest $request, AdminMonthlyBudget $adminMonthlyBudget)
    {
        try {

            $adminMonthlyBudget->date = Carbon::parse($request->date)->toDateString();
            $adminMonthlyBudget->month = $request->month;
            $adminMonthlyBudget->department_id = Auth::user()->department_id;
            $adminMonthlyBudget->user_id = Auth::user()->id;
            $adminMonthlyBudget->update();
            if($adminMonthlyBudget){
                $delete_old_details = AdminMonthlyBudgetDetail::where('budget_id', $adminMonthlyBudget->id)->delete();
                foreach ($request->budget_head_id as  $key => $detail) {
                        $add_budget_details = new adminMonthlyBudgetDetail;
                        $add_budget_details->budget_id = $adminMonthlyBudget->id;
                        $add_budget_details->budget_head_id = $request->budget_head_id[$key];
                        $add_budget_details->week_one = $request->week_one[$key];
                        $add_budget_details->week_two = $request->week_two[$key];
                        $add_budget_details->week_three = $request->week_three[$key];
                        $add_budget_details->week_four = $request->week_four[$key];
                        $add_budget_details->week_five = $request->week_five[$key];
                        $add_budget_details->remarks = $request->remarks[$key];
                        $add_budget_details->amount = $request->amount[$key];
                        $add_budget_details->save(); 
                }
            }
            return redirect()->route('admin-monthly-budgets.index')->with('message', 'Budget has been Updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminMonthlyBudget $adminMonthlyBudget)
    {
        try {
            $adminMonthlyBudget->delete($adminMonthlyBudget);
            return redirect()->route('admin-monthly-budgets.index')->with('message', 'Budget has been Deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function adminMonthlyBudgetReport(Request $request){
        $query_month = $request->month ? date('Y-m', strtotime($request->month)) : date('Y-m',strtotime(now()));
        $weeks = ['01', '02','03','04','05'];
        $budgets = AdminMonthlyBudget::with('adminMonthlyBudgetDetails')->where('month',$query_month)->first();
        if($request->reportType == 'pdf'){
            return PDF::loadview('admin_monthly_budgets.admin_monthly_budget_pdf', compact('request', 'query_month','budgets','weeks'))
                ->setPaper('a4', 'landscape')->stream('yearlyBudgetReport.pdf');
        }else{
            return view('admin_monthly_budgets.admin_monthly_budget_report', compact('request','query_month','budgets','weeks'));
        }
    }
}
