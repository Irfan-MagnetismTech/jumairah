<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Accounts\AdminYearlyBudget;
use App\Config\BudgetHead;
use App\Accounts\AdminYearlyBudgetDetail;
use App\Http\Requests\AdminYearlyBudgetRequest;
use Illuminate\Support\Facades\DB;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class AdminYearlyBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = AdminYearlyBudget::latest()->get();
        return view('admin_yearly_budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budget_heads = BudgetHead::get();
        return view('admin_yearly_budgets.create',compact('budget_heads'));
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
        'year' => 'required|unique:admin_yearly_budgets',
        ]);
        
        try {
            $add_budget = new AdminYearlyBudget;
            $add_budget->date = Carbon::parse($request->date)->toDateString();
            $add_budget->year = $request->year;
            $add_budget->department_id = Auth::user()->department_id;
            $add_budget->user_id = Auth::user()->id;
            $add_budget->save();
            if($add_budget){
                foreach ($request->month as  $key => $detail) {
                    $check_details = AdminYearlyBudgetDetail::where('month', $request->month[$key])->where('budget_head_id',$request->budget_head_id[$key])->first();
                    if($check_details){
                        $check_details->budget_id = $add_budget->id;
                        $check_details->budget_head_id = $request->budget_head_id[$key];
                        $check_details->month = $request->month[$key];
                        $check_details->remarks = $request->remarks[$key];
                        $check_details->amount = $request->amount[$key];
                        $check_details->update();
                    }else{
                        $add_budget_details = new AdminYearlyBudgetDetail;
                        $add_budget_details->budget_id = $add_budget->id;
                        $add_budget_details->budget_head_id = $request->budget_head_id[$key];
                        $add_budget_details->month = $request->month[$key];
                        $add_budget_details->remarks = $request->remarks[$key];
                        $add_budget_details->amount = $request->amount[$key];
                        $add_budget_details->save();
                    }
                }
            }
    //             $data = $request->only('year');
    //             $data['user_id'] = Auth()->user()->id;
    //             $data['user_id'] = Auth()->user()->department_id;
    //             $data['date'] = Carbon::parse($request->date)->toDateString();
    //             $detailsArray = array();
    //             foreach ($request->month as  $key => $detail) {
    //                 $detailsArray[] = [
    //                     'budget_head_id'      =>  $request->budget_head_id[$key],
    //                     'month'            =>  $request->month[$key],
    //                     'remarks'    =>  $request->remarks[$key],
    //                     'amount'    =>  $request->amount[$key],
    //                 ];
    //             }
    // //            dd($request->all(), $data);
    //             DB::transaction(function() use ($detailsArray, $data) {
    //                 $adminYearlyBudget = AdminYearlyBudget::create($data);
    //                 $adminYearlyBudget->AdminYearlyBudgetDetails()->createMany($detailsArray);
    //             });
            return redirect()->route('admin-yearly-budgets.index')->with('message', 'Budget has been added successfully');
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
    public function edit(AdminYearlyBudget $adminYearlyBudget)
    {
        $budget_heads = BudgetHead::get();
        return view('admin_yearly_budgets.create', compact('adminYearlyBudget', 'budget_heads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminYearlyBudgetRequest $request, AdminYearlyBudget $adminYearlyBudget)
    {
        try {

            $adminYearlyBudget->date = Carbon::parse($request->date)->toDateString();
            $adminYearlyBudget->year = $request->year;
            $adminYearlyBudget->department_id = Auth::user()->department_id;
            $adminYearlyBudget->user_id = Auth::user()->id;
            $adminYearlyBudget->update();
            if($adminYearlyBudget){
                $delete_old_details = AdminYearlyBudgetDetail::where('budget_id', $adminYearlyBudget->id)->delete();
                foreach ($request->month as  $key => $detail) {
                    $check_details = AdminYearlyBudgetDetail::where('month', $request->month[$key])->where('budget_head_id',$request->budget_head_id[$key])->first();
                    if($check_details){
                        $check_details->budget_id = $add_budget->id;
                        $check_details->budget_head_id = $request->budget_head_id[$key];
                        $check_details->month = $request->month[$key];
                        $check_details->remarks = $request->remarks[$key];
                        $check_details->amount = $request->amount[$key];
                        $check_details->update();
                    }else{
                        $add_budget_details = new AdminYearlyBudgetDetail;
                        $add_budget_details->budget_id = $adminYearlyBudget->id;
                        $add_budget_details->budget_head_id = $request->budget_head_id[$key];
                        $add_budget_details->month = $request->month[$key];
                        $add_budget_details->remarks = $request->remarks[$key];
                        $add_budget_details->amount = $request->amount[$key];
                        $add_budget_details->save();
                    }
                }
            }


            // $data = $request->only('year');
            // $data['user_id'] = auth()->user()->id;
            // $data['department_id'] = auth()->user()->department_id;
            // $data['date'] = Carbon::parse($request->date)->toDateString();
            // $detailsArray = array();
            // foreach ($request->month as  $key => $detail) {
            //     $detailsArray[] = [
            //         'budget_head_id'      =>  $request->budget_head_id[$key],
            //         'month'            =>  $request->month[$key],
            //         'remarks'    =>  $request->remarks[$key],
            //         'amount'    =>  $request->amount[$key],
            //     ];
            // }
            // DB::transaction(function() use ($detailsArray, $data, $adminYearlyBudget) {
            //     $adminYearlyBudget->update($data);
            //     $adminYearlyBudget->AdminYearlyBudgetDetails()->delete();
            //     $adminYearlyBudget->AdminYearlyBudgetDetails()->createMany($detailsArray);
            // });
            return redirect()->route('admin-yearly-budgets.index')->with('message', 'Budget has been Updated successfully');
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
    public function destroy(AdminYearlyBudget $adminYearlyBudget)
    {
        try {
            $adminYearlyBudget->delete($adminYearlyBudget);
            return redirect()->route('admin-yearly-budgets.index')->with('message', 'Budget has been Deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function adminYearlyBudgetReport(Request $request){
        $year = $request->year ? date('Y', strtotime($request->year)) : date('Y',strtotime(now()));
        $months = ['01', '02','03','04','05','06','07','08','09','10','11','12'];
        $budgets = AdminYearlyBudgetDetail::whereHas('adminYearlyBudget', function ($q) use($year){
            $q->where('year','2024');
        })->get()
        ->groupBy(['budget_head_id','month'])
        ->map(function ($item, $key) use($months, $year){
            $array = array();
            $budget_array = array();
            $budget_array[] = $key;
            $monthlyTotal = 0;
            foreach ($months as $month){
                $detailsData = AdminYearlyBudgetDetail::where('budget_head_id', $key)->where('month',"$year-$month")->first();

                $array[] = [
                    "amount" => $detailsData->amount ?? 0,

                ];

            }

            return [
                'yearlyBudgets' => $array,
                'budget_heads' => $budget_array,
            ];
        });

        if($request->reportType == 'pdf'){
            return PDF::loadview('admin_yearly_budgets.admin_yearly_budget_pdf', compact('request', 'year','budgets','months'))
                ->setPaper('a4', 'landscape')->stream('yearlyBudgetReport.pdf');
        }else{
            return view('admin_yearly_budgets.admin_yearly_budget_report', compact('request','year','budgets','months'));
        }
    }
}
