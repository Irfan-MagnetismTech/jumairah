<?php

namespace App\Http\Controllers\Construction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Construction\TentativeBudget;
use App\Construction\TentativeBudgetDetail;
use DB;
use App\Http\Requests\Construction\TentativeBudgetRequest;
use Spatie\Permission\Traits\HasRoles;

class TentativeBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:construction-tentative-budget-view|construction-tentative-budget-create|construction-tentative-budget-edit|construction-tentative-budget-delete', ['only' => ['index','show']]);
        $this->middleware('permission:construction-tentative-budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:construction-tentative-budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:construction-tentative-budget-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tentative_budget_data = TentativeBudget::orderBy('applied_date', 'desc')->get();
        return view('construction.tentative-budget.index', compact('tentative_budget_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('construction.tentative-budget.create',compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TentativeBudgetRequest $request)
    {
        try {
            $tentativeBudgetData = array();
            foreach ($request->tentative_month as  $key => $data) {
                $tentativeBudgetData[] = [
                    'cost_center_id'            =>  $request->cost_center_id,
                    'applied_year'              =>  $request->applied_year,
                    'tentative_month'           =>  $request->tentative_month[$key],
                    'material_cost'             =>  $request->material_cost[$key],
                    'labor_cost'                =>  $request->labor_cost[$key],
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ];
            }
            DB::transaction(function () use ($tentativeBudgetData) {
                TentativeBudget::insert($tentativeBudgetData);
            });
            return redirect()->route('construction.tentative-budget-list')->with('message', 'Budget has been added successfully');
        } catch (\QueryException $e) {
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
    public function edit(TentativeBudget $tentative_budget)
    {
        $formType = "edit";
        return view('construction.tentative-budget.create', compact('formType', 'tentative_budget'));
    }
    public function TentativeBudgetEdit($year,$cost_center_id)
    {
        $tentative_budget = TentativeBudget::where('cost_center_id',$cost_center_id)->where('applied_year',$year)->get();
        $formType = "edit";
        return view('construction.tentative-budget.create', compact('formType', 'tentative_budget'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TentativeBudgetRequest $request, TentativeBudget $tentative_budget)
    {
        try {
            $tentativeBudgetData = $request->only('applied_date', 'total_january_material', 'total_january_labor', 'total_february_material', 'total_february_labor', 'total_march_material', 'total_march_labor',
            'total_april_material','total_april_labor','total_may_material','total_may_labor','total_june_material','total_june_labor','total_july_material','total_july_labor','total_august_material','total_august_labor','total_september_material','total_september_labor','total_october_material','total_october_labor','total_november_material','total_november_labor','total_december_material','total_december_labor','total_amount','total_tergeted_build_up_area');
            $tentativeBudgetData['applied_date'] =  $this->formatDate($request->applied_date);
            $tentativeBudgetDetailData = array();
            foreach ($request->cost_center_id as  $key => $data) {
                $tentativeBudgetDetailData[] = [
                    'cost_center_id'       =>  $request->cost_center_id[$key],
                    'amount'           =>  $request->amount[$key],
                    'january_material'          =>  $request->january_material[$key],
                    'february_material'         =>  $request->february_material[$key],
                    'march_material'            =>  $request->march_material[$key],
                    'april_material'            =>  $request->april_material[$key],
                    'may_material'              =>  $request->may_material[$key],
                    'june_material'             =>  $request->june_material[$key],
                    'july_material'             =>  $request->july_material[$key],
                    'august_material'           =>  $request->august_material[$key],
                    'september_material'        =>  $request->september_material[$key],
                    'october_material'          =>  $request->october_material[$key],
                    'november_material'         =>  $request->november_material[$key],
                    'december_material'         =>  $request->december_material[$key],
                    'january_labor'          =>  $request->january_labor[$key],
                    'february_labor'         =>  $request->february_labor[$key],
                    'march_labor'            =>  $request->march_labor[$key],
                    'april_labor'            =>  $request->april_labor[$key],
                    'may_labor'              =>  $request->may_labor[$key],
                    'june_labor'             =>  $request->june_labor[$key],
                    'july_labor'             =>  $request->july_labor[$key],
                    'august_labor'           =>  $request->august_labor[$key],
                    'september_labor'        =>  $request->september_labor[$key],
                    'october_labor'          =>  $request->october_labor[$key],
                    'november_labor'         =>  $request->november_labor[$key],
                    'december_labor'         =>  $request->december_labor[$key],
                    'tergeted_build_up_area' =>  $request->tergeted_build_up_area[$key]
                ];
            }

            DB::transaction(function () use ($tentativeBudgetData, $tentativeBudgetDetailData , $tentative_budget) {
                $tentative_budget->update($tentativeBudgetData);
                $tentative_budget->tentativeBudgetDetails()->delete();
                $tentative_budget->tentativeBudgetDetails()->createMany($tentativeBudgetDetailData);
            });
            return redirect()->route('construction.tentative-budget-list')->with('message', 'Budget has been added successfully');
        } catch (\QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function TentativeBudgetUpdate(Request $request){
        try{
            $data_for_delete = TentativeBudget::where('cost_center_id',$request->cost_center_id)
                                ->where('applied_year',$request->applied_year)
                                ->get(['id'])
                                ->toArray();
            $tentativeBudgetData = array();
            foreach ($request->tentative_month as  $key => $data) {
                $tentativeBudgetData[] = [
                    'cost_center_id'            =>  $request->cost_center_id,
                    'applied_year'              =>  $request->applied_year,
                    'tentative_month'           =>  $request->tentative_month[$key],
                    'material_cost'             =>  $request->material_cost[$key],
                    'labor_cost'                =>  $request->labor_cost[$key],
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ];
            }

            DB::transaction(function () use ($tentativeBudgetData,$data_for_delete) {
                TentativeBudget::destroy($data_for_delete);
                TentativeBudget::insert($tentativeBudgetData);
            });
            return redirect()->route('construction.tentative-budget-list')->with('message', 'Budget has been updated successfully');
        } catch (\QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
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


    public function TentativeBudgetPdf($id){
       $tentative_budget = TentativeBudget::findOrFail($id);
       return \PDF::loadview('construction.tentative-budget.pdf', compact('tentative_budget'))->setPaper('A4', 'landscape')->stream('tentative_budget.pdf');

       return view('construction.tentative-budget.pdf',compact('tentative_budget'));
    }

    public function yearList(){
        $years = TentativeBudget::query()
                    ->groupBy('applied_year')
                    ->pluck('applied_year');

        return view('construction.tentative-budget.yearList',compact('years'));
    }
    public function budgetDetails($year){
        $tentative_budgets = TentativeBudget::query()
                    ->with(['costCenter.project.boqCivilBudgets','costCenter.project.boqFloorProjects'])
                    ->whereApplied_year($year)
                    ->get()
                    ->groupBy(['cost_center_id','tentative_month']);
        return view('construction.tentative-budget.index', compact('tentative_budgets'));
    }
    private function formatDate(string $date): string
    {
        // dd(substr( date_format(date_create($date),"Y-m-d"), 0));
        // dd(date('Y-m-d', strtotime($date)));
       return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}
