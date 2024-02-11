<?php

namespace App\Http\Controllers\Construction;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Projects\BoqFloorProject;
use App\Construction\ProjectProgressReport;
use App\Construction\ProjectProgressReportDetails;
use App\Construction\TentativeBudget;
use App\Construction\TentativeBudgetDetail;
use App\CostCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Construction\ProjectProgressReportRequest;
use App\LedgerEntry;
use App\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class ProjectProgressReportController extends Controller
{
    
    
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:construction-project-progress-report-view|construction-project-progress-report-create|construction-project-progress-report-edit|construction-project-progress-report-delete', ['only' => ['index','show','year','month','progressReport']]);
        $this->middleware('permission:construction-project-progress-report-create', ['only' => ['create','store']]);
        $this->middleware('permission:construction-project-progress-report-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:construction-project-progress-report-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress_data = ProjectProgressReport::get();
        return view('construction.project-progress-report.index',compact('progress_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('construction.project-progress-report.create',compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectProgressReportRequest $request)
    {
        try{
            $progress_data['applied_by']  = auth()->id();

            $progress_details_data = array();
            foreach($request->cost_center_id as  $key => $data){

            $date_of_inception = $this->formatDate($request->date_of_inception[$key]);
            $date_of_completion = $this->formatDate($request->date_of_completion[$key]);

                $progress_details_data[] = [
                    'cost_center_id'        =>  $request->cost_center_id[$key],
                    'date_of_inception'     =>  $date_of_inception,
                    'date_of_completion'    =>  $date_of_completion
                ];
            }

            DB::transaction(function()use($progress_data, $progress_details_data){
                $project_progress_report = ProjectProgressReport::create($progress_data);
                $project_progress_report->ProjectProgressReportDetails()->createMany($progress_details_data);
            });

            return redirect()->route('construction.monthly_progress_report.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(ProjectProgressReport $monthly_progress_report)
    {
        // dd($monthly_progress_report);
        $formType = 'edit';
        return view('construction.project-progress-report.create',compact('formType', 'monthly_progress_report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectProgressReportRequest $request, ProjectProgressReport $monthly_progress_report)
    {
        
        try{
            $progress_data['applied_by']  = auth()->id();

            $progress_details_data = array();
            foreach($request->cost_center_id as  $key => $data){

            $date_of_inception = $this->formatDate($request->date_of_inception[$key]);
            $date_of_completion = $this->formatDate($request->date_of_completion[$key]);

                $progress_details_data[] = [
                    'cost_center_id'        =>  $request->cost_center_id[$key],
                    'date_of_inception'     =>  $date_of_inception,
                    'date_of_completion'    =>  $date_of_completion
                ];
            }

            DB::transaction(function()use($progress_data, $progress_details_data, $monthly_progress_report){
                $monthly_progress_report->update($progress_data);
                $monthly_progress_report->tentativeBudgetDetails()->delete();
                $monthly_progress_report->ProjectProgressReportDetails()->createMany($progress_details_data);
            });

            return redirect()->route('construction.monthly_progress_report.index')->with('message', 'Data has been inserted successfully');
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
    public function destroy(ProjectProgressReport $monthly_progress_report)
    {
        try{
            $monthly_progress_report->delete();
            return redirect()->route('monthly_progress_report.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('monthly_progress_report.index')->withErrors($e->getMessage());
        }
    }

    /**
     *  Formats the date into y.
     *
     * @return string
     */
    private function formatYear(string $date): string
    {
        return substr( date_format(date_create($date),"Y"), 0);
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

    private function formatDate(string $date): string
    {
        return substr( date_format(date_create($date),"Y-m-d"), 0);
    }

    public function year(){
        $years = Transaction::query()
            ->select(\DB::raw('year(transaction_date) as year'))
            ->groupBy(\DB::raw('year(transaction_date)'))
            ->pluck('year');
        return view('construction.project-progress-report.yearList',compact('years'));
    }

    public function month($year){
        $months = Transaction::query()
            ->whereYear('transaction_date',$year)
            ->select(\DB::raw('month(transaction_date) as month'))
            ->groupBy(\DB::raw('month(transaction_date)'))
            ->pluck('month');
        return view('construction.project-progress-report.monthList',compact('months','year'));
    }

    public function progressReport($year, $month){

        $data = LedgerEntry::whereHas('costCenter',function ($q){ $q->where('project_id','!=',null); })
            ->get()
            ->groupBy('cost_center_id') ; 
        $projects = $data->map(function($item, $key) use ($month, $year) {
            $materials = LedgerEntry::whereHas('account', function ($q) {
                $q->where('parent_account_id',139);
            })->whereHas('transaction', function ($q) use ($month,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date', $month);
            })->where('cost_center_id',$key)->get();

            $labors = LedgerEntry::whereHas('account', function ($q){
                $q->where('parent_account_id',138);
            })->whereHas('transaction', function ($q) use ($month,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$month);
            })->where('cost_center_id',$key)->get();

            $progressData = ProjectProgressReportDetails::where('cost_center_id', $key)->first();
            $costCenter = CostCenter::where('id',$key)->first();
            $constructionArea = BoqFloorProject::where('project_id', $costCenter->project_id)->get()->groupBy('project_id');
            $projet_cost = BoqCivilBudget::where('project_id', $costCenter->project_id)->get()->groupBy('project_id');

            $tentative_budget = TentativeBudget::
                where('cost_center_id', $key)
                ->where('applied_year', $year)
                ->where('tentative_month', $month)
            ->first();

            // $todate = date('Y-m-d', strtotime(now()));
            $cumulative_materials = LedgerEntry::whereHas('account', function ($q) {
                        $q->where('parent_account_id',139);
                    })
                    // ->whereHas('transaction', function ($q) use ($progressData, $todate){
                    //     $q->when($progressData, function ($j) use($progressData, $todate){ 
                    //         $j->whereBetween('transaction_date',[$progressData->date_of_inception, $todate]);
                    //     });
                    // })
                ->where('cost_center_id',$key)->get();

            $cumulative_labors = LedgerEntry::whereHas('account', function ($q) {
                $q->where('parent_account_id',138);
            // })->whereHas('transaction', function ($q) use ($progressData, $todate){
            //     $q->whereBetween('transaction_date',[$progressData->date_of_inception, $todate]);
            })->where('cost_center_id',$key)->get();

            $total_achivement_cost = $cumulative_materials->flatten()->sum('dr_amount') + $cumulative_labors->flatten()->sum('dr_amount');
            $percent_of_completion = $projet_cost->flatten()->sum('total_amount') > 0 ? $total_achivement_cost / $projet_cost->flatten()->sum('total_amount') * 100 : 0; 
            $cumulative_total_buildup_area = number_format($percent_of_completion,2) * $constructionArea->flatten()->sum('area');

            return [
                'costCenter' => $costCenter->name,
                'inceptionDate'=> $progressData->date_of_inception ?? '',
                'completionDate'=> $progressData->date_of_completion ?? '',

                'material' => $materials->flatten()->sum('dr_amount'),
                'labors' => $labors->flatten()->sum('dr_amount'),
                'totalConstructionArea' => $constructionArea->flatten()->sum('area'),
                'total_projet_cost' => $projet_cost->flatten()->sum('total_amount'),

                'tentative_budget_material_cost' => $tentative_budget->material_cost ?? 0,
                'tentative_budget_labor_cost' => $tentative_budget->labor_cost ?? 0,
                'cumulative_total_buildup_area' => $cumulative_total_buildup_area,
            ];

           
        });


        return view('construction.project-progress-report.progress-report',compact('month','year','projects'));
    }

}
