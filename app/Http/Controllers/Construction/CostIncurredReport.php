<?php

namespace App\Http\Controllers\construction;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Projects\BoqFloorProject;
use App\Construction\TentativeBudget;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class CostIncurredReport extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:construction-cost-incurred-report-view', ['only' => ['CostIncurredYearList','CostIncurredReport']]);
        
    }


    public function CostIncurredYearList(){
        $years = Transaction::query()
            ->select(\DB::raw('year(transaction_date) as year'))
            ->groupBy(\DB::raw('year(transaction_date)'))
            ->pluck('year');
            return view('construction.cost-incurred.year-list', compact('years'));
    }

    // public function CostIncurredReport($year){ 

    //     $month = 1;  $totalmonthlyAchievements =[];
    //     for($month; $month <=12; $month++){ 
    //         $materials  = LedgerEntry::whereHas('account', function ($q) {
    //             $q->where('parent_account_id',139);
    //         })->whereHas('transaction', function ($q) use ( $year, $month){
    //             $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month);
    //         })->sum('dr_amount'); 

    //         $labors  = LedgerEntry::whereHas('account', function ($q) {
    //             $q->where('parent_account_id',138);
    //         })->whereHas('transaction', function ($q) use ( $year, $month){
    //             $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month);
    //         })->sum('dr_amount'); 

    //         $targets = TentativeBudget::where('applied_year',$year)->where('tentative_month', $month)->sum('material_cost','labor_cost'); //c

    //         $constructionArea = BoqFloorProject::get();
    //         $total_area_in_sft = $constructionArea->sum('area'); //4

    //         $projet_cost = BoqCivilBudget::get();
    //         $total_cost_as_per_boq = $projet_cost->sum('total_amount'); //k

    //         $total_labor_and_material_cost_of_a_year_of_a_month = $materials + $labors ; //z
    //         $percent_of_completion = $total_labor_and_material_cost_of_a_year_of_a_month / $total_cost_as_per_boq * 100; //12

    //         $monthly_achivement_area_for_all_project_of_a_year = $total_area_in_sft * $percent_of_completion;

    //         $percent_of_target = $targets / $total_cost_as_per_boq * 100; //11

    //         $monthly_target_area_for_all_project_of_a_year = $percent_of_target * $total_area_in_sft;

    //         // dump($monthly_achivement_area_for_all_project_of_a_year);

    //         $totalmonthlyAchievements[] = [
    //             'achievements'          => $materials + $labors,
    //             'target'                => $targets,
    //             'achievements_in_sft'   => $monthly_achivement_area_for_all_project_of_a_year,
    //             'target_in_sft'         => $monthly_target_area_for_all_project_of_a_year,

    //         ] ;

    //     }
    //     // dump($totalmonthlyAchievements);

    //     return view('construction.cost-incurred.cost_incurred_report', compact('totalmonthlyAchievements', 'year'));
    // }





    public function CostIncurredReport($year){ 

        $totalmonthlyAchievements =[];
        if($year == date('Y')){
            $total_month = date('m');
        }else{
            $total_month = 12;
        }
        $Tentative_budget_labor_total = TentativeBudget::query()
            ->where('applied_year',$year)
            ->sum('labor_cost');
        $Tentative_budget_material_total = TentativeBudget::query()
            ->where('applied_year',$year)
            ->sum('material_cost');
            
        $tentative_budget_total = $Tentative_budget_labor_total +  $Tentative_budget_material_total; 
        
        $total_area_in_sft =  BoqFloorProject::get()->sum('area');

        $total_cost_as_per_boq = BoqCivilBudget::get()->sum('total_amount');
        for($month = 1; $month <=$total_month; $month++){ 
            
            $total_material_labor = LedgerEntry::whereHas('account', function ($q) {
                $q->whereIn('parent_account_id',[138,139]);
            })->whereHas('transaction', function ($q) use ( $year, $month){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month);
            })->sum('dr_amount');  

            $target_labor = TentativeBudget::where('applied_year',$year)->where('tentative_month', $month)->sum('labor_cost'); //c
            $target_material = TentativeBudget::where('applied_year',$year)->where('tentative_month', $month)->sum('material_cost');

            $monthly_achivement_area_for_all_project_of_a_year = $total_material_labor  / $total_cost_as_per_boq * $total_area_in_sft ; //12

             $monthly_target_area_for_all_project_of_a_year = ($target_labor + $target_material) / $total_cost_as_per_boq * $total_area_in_sft; //11

            // dump($monthly_achivement_area_for_all_project_of_a_year);

            $totalmonthlyAchievements[$month] = [
                'achievements'          => $total_material_labor,
                'target'                => $target_labor + $target_material,
                'achievements_in_sft'   => $monthly_achivement_area_for_all_project_of_a_year,
                'target_in_sft'         => $monthly_target_area_for_all_project_of_a_year ?? 0,

            ] ;

        }
        return view('construction.cost-incurred.cost_incurred_report', compact('total_area_in_sft','total_cost_as_per_boq','tentative_budget_total','total_month','totalmonthlyAchievements', 'year'));
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
    public function edit($id)
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
    public function update(Request $request, $id)
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

}
