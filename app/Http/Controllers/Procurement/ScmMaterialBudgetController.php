<?php

namespace App\Http\Controllers\Procurement;

use App\Construction\MaterialPlan;
use App\Construction\MaterialPlanDetail;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Procurement\Supplierbill;
use App\Project;
use App\Transaction;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScmMaterialBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
//        $this->middleware('permission:scm-material-budget', ['only' => ['yearList','monthList', 'direction', 'projectList', 'budgetDetails', 'budgetDashboard', 'paymentDashboard', 'store',]]);
        $this->middleware('permission:scm-material-budget-dashboard', ['only' => ['yearList', 'monthList', 'direction', 'budgetDetails', 'budgetDashboard','paymentDashboard']]);
    }

    /**
     * project wise year list.
     *@param  int $project
     * @return \Illuminate\Http\Response
     */
    public function yearList()
    {
        $data = MaterialPlan::orderBy('year', 'desc')->get();
        $years = $data->groupBy('year')->all();
        return view('procurement.scm-material-budget.cardyear', compact('years'));
    }

     /**
     * year wise month list.
     *@param  int $work_plan_id
     *@param  int $year
     * @return \Illuminate\Http\Response
     */
    public function monthList($year)
    {
        $data = MaterialPlan::where('year', $year)->get();
        $months = $data->groupBy('month')->all();
        return view('procurement.scm-material-budget.monthList', compact('months'));
    }

    public function direction($year, $month)
    {
        return view('procurement.scm-material-budget.direction', compact('year', 'month'));
    }

    /**
     * year and monthwise project list.
     *@param  Year $year
     *@param  int $month
     * @return \Illuminate\Http\Response
     */
    public function projectList($year, $month)
    {
        $projects = MaterialPlan::where('year', $year)->where('month', $month)->get();
        return view('procurement.scm-material-budget.projectList', compact('projects'));
    }

    /**
     * year and monthwise material budget details.
     *@param  Year $year
     *@param  int $month
     * @return \Illuminate\Http\Response
     */
    public function budgetDetails($year, $month, $project_id, $material_plan_id)
    {
        $formType       = "create";
        $materialPlan = MaterialPlan::where('id', $material_plan_id)->first();
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        $currentYearPlans = MaterialPlanDetail::with('materialPlan')
        ->whereHas('materialPlan', function($q)use($year, $month, $project_id){
            return $q->where('year', $year)->where('month', $month)->where('project_id', $project_id)->groupBy('material_plan_id');
        })
        ->get();
        return view('procurement.scm-material-budget.create', compact('formType', 'materialPlan', 'currentYearPlans', 'year', 'month', 'project_id', 'projects', 'material_plan_id'));
    }


    public function ScmMaterialBudgetPdf(Request $request, $year, $month, $project_id, $material_plan_id)
    {
        $materialPlan = MaterialPlan::where('id', $material_plan_id)->first();
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        $currentYearPlans = MaterialPlanDetail::with('materialPlan')
        ->whereHas('materialPlan', function($q)use($year, $month, $project_id){
            return $q->where('year', $year)->where('month', $month)->where('project_id', $project_id)->groupBy('material_plan_id');
        })
        ->get();

        return \PDF::loadview('procurement.scm-material-budget.scm-material-rate-pdf', compact('materialPlan', 'currentYearPlans', 'year', 'month', 'project_id', 'material_plan_id'))->setPaper('A4', 'landscape')->stream('Material-Rate.pdf');
    }


    public function budgetDashboard($year, $month)
    {
        $materialPlans = MaterialPlan::where('year', $year)->where('month', $month)->get();
        $dates =[
            'year' => $year,
            'month' => $month
        ];
        return view('procurement.scm-material-budget.budget-dashboard', compact('year', 'month', 'materialPlans', 'dates'));
    }

    public function paymentDashboard($year, $month)
    {
        $currentMonth = "$year-$month-01";
        $materialPlans = MaterialPlan::where('year', $year)->where('month', $month)->get();
        $supplierBillCarryingCharge = Supplierbill::sum('carrying_charge');
        $supplierBillLaborCharge = Supplierbill::sum('labour_charge');
        $supplierBillDiscount = Supplierbill::sum('discount');
        $supplierBillFinalTotal = Supplierbill::sum('final_total');

        $totalSupplierBill = $supplierBillFinalTotal + $supplierBillCarryingCharge + $supplierBillLaborCharge - $supplierBillDiscount;

        $supplierPayment =  LedgerEntry::whereHas('transaction', function ($q) use($currentMonth){
                              $q->whereDate('transaction_date', '<', $currentMonth);
                            })->whereHas('account', function ($q){
                                $q->where('balance_and_income_line_id', 34)
                                ->where('parent_account_id',101);
                            })->sum('dr_amount');
        $totalBillOutstanding = $totalSupplierBill - $supplierPayment;

        $previousMonth = Carbon::parse($currentMonth)->subMonths('1')->format('F Y');
        $dates =[
            'year' => $year,
            'month' => $month
        ];
        return view('procurement.scm-material-budget.payment-dashboard', compact('year', 'month', 'materialPlans', 'totalBillOutstanding', 'previousMonth', 'dates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{
        foreach($request->id as $key => $id ){
            DB::transaction(function()use($request,$key){
                MaterialPlanDetail::updateOrCreate(
                    [
                    'id'                => $request->id[$key],
                    'material_id'       => $request->material_id[$key]
                    ],
                    [
                    'week_one_rate'     => $request->week_one_rate[$key],
                    'week_two_rate'     => $request->week_two_rate[$key],
                    'week_three_rate'   => $request->week_three_rate[$key],
                    'week_four_rate'    => $request->week_four_rate[$key],
                    ],
                );
            });
        }
            return redirect()->route('scm-material-budget-details',[$request->year,$request->month,$request->project_id,$request->material_plan_id])->with('message', 'Data has been inserted successfully');
       }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
       }
    }



    public function budgetDashboardPDF(Request $request)
    {
        $year = $request->dates['year'];
        $month = $request->dates['month'];
        $materialPlans = MaterialPlan::where('year', $year)->where('month', $month)->get();

    return \PDF::loadview('procurement.scm-material-budget.material-budget-pdf', compact('year', 'month', 'materialPlans'))->setPaper('A4', 'landscape')->stream('Material-Budget-Rate.pdf');
    }

    public function paymentDashboardPDF(Request $request)
    {
        $year = $request->dates['year'];
        $month = $request->dates['month'];

        $currentMonth = "$year-$month-01";
        $materialPlans = MaterialPlan::where('year', $year)->where('month', $month)->get();
        $supplierBillCarryingCharge = Supplierbill::sum('carrying_charge');
        $supplierBillLaborCharge = Supplierbill::sum('labour_charge');
        $supplierBillDiscount = Supplierbill::sum('discount');
        $supplierBillFinalTotal = Supplierbill::sum('final_total');

        $totalSupplierBill = $supplierBillFinalTotal + $supplierBillCarryingCharge + $supplierBillLaborCharge - $supplierBillDiscount;

        $supplierPayment =  LedgerEntry::whereHas('transaction', function ($q) use($currentMonth){
                              $q->whereDate('transaction_date', '<', $currentMonth);
                            })->whereHas('account', function ($q){
                                $q->where('balance_and_income_line_id', 34)
                                ->where('parent_account_id',101);
                            })->sum('dr_amount');
        $totalBillOutstanding = $totalSupplierBill - $supplierPayment;

        $previousMonth = Carbon::parse($currentMonth)->subMonths('1')->format('F Y');

    return \PDF::loadview('procurement.scm-material-budget.payment-dashboard-pdf', compact('year', 'month', 'materialPlans', 'totalBillOutstanding', 'previousMonth'))
            ->setPaper('legal', 'landscape')
            ->stream('Material-Budget-Payment.pdf');
    }

}
