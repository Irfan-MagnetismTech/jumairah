<?php

namespace App\Http\Controllers\Construction;

use App\Project;
use Illuminate\Http\Request;
use App\Construction\WorkPlan;
use Illuminate\Support\Facades\DB;
use App\Procurement\NestedMaterial;
use App\Construction\WorkPlanDetail;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\QueryException;
use App\Http\Requests\Construction\WorkPlanRequest;
use Barryvdh\DomPDF\Facade as PDF;

class WorkPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:construction-action-plan-view|construction-work-plan-create|construction-work-plan-edit|construction-work-plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:construction-action-plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:construction-action-plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:construction-action-plan-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WorkPlanDetail::orderBy('year', 'desc')->get();
        $years = $data->groupBy('year')->all();
        $projects = Project::orderBy('name')->pluck('name', 'id');
        return view('construction.workplan.cardyear', compact('projects',   'years'));
    }


    /**
     * project wise year list.
     *@param  int $project
     * @return \Illuminate\Http\Response
     */
    public function yearList($work_plan_id, $project)
    {
        $projec_data = WorkPlan::where('workPlan_id', $work_plan_id)->where('project_id', $project)->get();
        $years = $projec_data[0]->workPlanDetails->groupBy('year')->all();
        return view('construction.workplan.cardyear', compact('years'));
    }

    /**
     * year wise month list.
     *@param  int $work_plan_id
     *@param  int $year
     * @return \Illuminate\Http\Response
     */
    public function monthList( $year)
    {
        $data = WorkPlanDetail::where('year', $year)->get();
        $months = $data->groupBy('month')->all();
        // dd($months);
        return view('construction.workplan.month_list', compact('months'));
    }


    /**
     * year and monthwise plan list.
     *@param  int $year
     *@param  int $month
     * @return \Illuminate\Http\Response
     */
    public function planDetails($year, $month)
    {
        $currentYearPlans = WorkPlan::with('workPlanDetails', 'projects')
        ->whereHas('workPlanDetails', function($q)use($year, $month){
            return $q->where('year', $year)->where('month', $month)->groupBy('work_id');
        })
        ->get();
        return view('construction.workplan.index', compact('currentYearPlans', 'year', 'month'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType       = "create";
        $workPlan       = new WorkPlan();
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        return view('construction.workplan.create', compact('projects', 'formType', 'workPlan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkPlanRequest $request)
    {
        try {
            $workPlan = new WorkPlan();
            $workPlanData = $request->only('project_id');
            $workPlanData['user_id'] = auth()->id();
            $workPlanData['is_saved'] = 1;
            $workPlanData['applied_by'] = auth()->id();

            $workPlanDetailData = array();

            foreach ($request->work_id as  $key => $data) {
                $year = $this->formatYear($request->start_date[$key]);
            $month = $this->formatMonth($request->finish_date[$key]);
                $workPlanDetailData[] = [

                    'work_id'       =>  $request->work_id[$key],
                    'sub_work'      =>  $request->sub_work[$key],
                    'target'        =>  $request->target[$key],
                    'target_accomplishment'=>  $request->target_accomplishment[$key],
                    'description'   =>  $request->description[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'architect_eng_name'      =>  $request->architect_eng_name[$key],
                    'sc_eng_name'      =>  $request->sc_eng_name[$key],
                    'start_date'    =>  $request->start_date[$key],
                    'year'          =>  $year,
                    'finish_date'   =>  $request->finish_date[$key],
                    'month'         => $month,
                    'delay'         =>  $request->delay[$key]
                ];
            }
            $workPlanId = "";
            DB::transaction(function () use ($workPlanData, $workPlanDetailData, &$workPlanId) {
                $workPlan = WorkPlan::create($workPlanData);
                $workPlan->workPlanDetails()->createMany($workPlanDetailData);
                $workPlanId = $workPlan->id;
            });

            return redirect()->route('construction.work-plan-show', ['year' => $year, 'month' => $month, 'id' => $workPlanId])->with('message', 'Data has been inserted successfully');
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
    public function show(WorkPlan $workPlan, $year, $month)
    {
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        $currentYearPlans = WorkPlan::with('workPlanDetails', 'projects')
        ->whereHas('workPlanDetails', function($q)use($year, $month){
            return $q->where('year', $year)->where('month', $month)->groupBy('work_id');
        })
        ->get();
        return view('construction.workplan.show', compact('workPlan','projects', 'currentYearPlans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkPlan $workPlan)
    {
        $formType       = "edit";
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        return view('construction.workplan.create', compact('workPlan','formType', 'projects'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkPlanRequest $request, WorkPlan $workPlan)
    {
        try {
            $workPlanData = $request->only('project_id');
            $workPlanData['is_saved'] = 1;

            $workPlanDetailData = array();

            foreach ($request->work_id as  $key => $data) {
                $year = $this->formatYear($request->start_date[$key]);
                $month = $this->formatMonth($request->finish_date[$key]);
                $workPlanDetailData[] = [
                    'work_id'       =>  $request->work_id[$key],
                    'sub_work'      =>  $request->sub_work[$key],
                    'target'        =>  $request->target[$key],
                    'target_accomplishment'=>  $request->target_accomplishment[$key],
                    'description'   =>  $request->description[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'architect_eng_name'      =>  $request->architect_eng_name[$key],
                    'sc_eng_name'      =>  $request->sc_eng_name[$key],
                    'start_date'    =>  $request->start_date[$key],
                    'year'          =>  $year,
                    'finish_date'   =>  $request->finish_date[$key],
                    'month'         =>  $month,
                    'delay'         =>  $request->delay[$key]
                ];
            }
            DB::transaction(function () use ($workPlan, $workPlanData, $workPlanDetailData) {
                $workPlan->update($workPlanData);
                $workPlan->workPlanDetails()->delete();
                $workPlan->workPlanDetails()->createMany($workPlanDetailData);
            });

            return redirect()->route('construction.planDetails', ['year' => $year, 'month' => $month])->with('message', 'Data has been Updated successfully');
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
    public function destroy(WorkPlan $workPlan)
    {
        // dd($workPlan);
    }


    /**
     * pdf for specific month of a year.
     *
     * @param  int  $year $month
     * @return \Illuminate\Http\Response
     */
    public function pdf($year, $month)
    {
        $currentYearPlans = WorkPlan::with('workPlanDetails', 'projects')
        ->whereHas('workPlanDetails', function($q)use($year, $month){
            return $q->where('year', $year)->where('month', $month)->groupBy('work_id');
        })
        ->get();
        return PDF::loadview('construction.workplan.pdf', compact('currentYearPlans'))->setPaper('a4', 'landscape')->stream('action-plan.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByProjectEng(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $materialPlan = WorkPlan::where('id', $request->id)->first();
        $currentYearPlans = WorkPlan::with('workPlanDetails', 'projects')
        ->whereHas('workPlanDetails', function($q)use($year, $month){
            return $q->where('year', $year)->where('month', $month)->groupBy('work_id');
        })
        ->get();
        return view('construction.workplan.show', compact('currentYearPlans', 'year', 'month'));

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

    public function DraftSave(Request $request){
        try{
            $workPlanData = $request->only('project_id');
            $workPlanData['applied_by'] = auth()->id();
            $workPlanData['user_id'] = auth()->user()->id;
            $workPlanDetailData = array();

            foreach ($request->work_id as  $key => $data) {
                if(isset($request->start_date[$key]) && $request->start_date[$key] != null){
                    $year = $this->formatYear($request->start_date[$key]);
                    $urlYear = $this->formatYearforUrl($request->start_date[$key]);
                }else{
                    $year = null;
                }

                if(isset($request->finish_date[$key]) && $request->finish_date[$key] != null){
                    $month = $this->formatMonth($request->finish_date[$key]);
                    $urlMonth = $this->formatMonthforUrl($request->finish_date[$key]);
                }else{
                    $month = null;
                }

                $workPlanDetailData[] = [

                    'work_id'               =>  $request->work_id[$key] ?? null,
                    'sub_work'              =>  $request->sub_work[$key] ?? null,
                    'target'                =>  $request->target[$key] ?? null,
                    'target_accomplishment' =>  $request->target_accomplishment[$key] ?? null,
                    'description'           =>  $request->description[$key] ?? null,
                    'material_id'           =>  $request->material_id[$key] ?? null,
                    'architect_eng_name'    =>  $request->architect_eng_name[$key] ?? null,
                    'sc_eng_name'           =>  $request->sc_eng_name[$key] ?? null,
                    'start_date'            =>  $request->start_date[$key] ?? null,
                    'year'                  =>  $year ?? null,
                    'finish_date'           =>  $request->finish_date[$key] ?? null,
                    'month'                 => $month ?? null,
                    'delay'                 =>  $request->delay[$key] ?? null
                ];
            }
            $workPlanId = "";

    if(isset($request->draft_id) && $request->draft_id != null){
        $workPlan = WorkPlan::findOrFail($request->draft_id);
        DB::transaction(function () use ($workPlan, $workPlanData, $workPlanDetailData) {
            $workPlan->update($workPlanData);
            $workPlan->workPlanDetails()->delete();
            $workPlan->workPlanDetails()->createMany($workPlanDetailData);
        });
    }else{
        DB::transaction(function () use ($workPlanData, $workPlanDetailData, &$workPlanId) {
            $workPlan = WorkPlan::create($workPlanData);
            $workPlan->workPlanDetails()->createMany($workPlanDetailData);
            $workPlanId = $workPlan->id;
        });
    }
    return redirect()->route('construction.planDetails', ['year' => $urlYear, 'month' => $urlMonth])->with('message', 'Draft has been Saved successfully');
    } catch (QueryException $e) {
        return redirect()->back()->withInput()->withErrors($e->getMessage());
      }
    }
    private function formatMonthforUrl(string $date): string
    {
        return substr( date_format(date_create($date),"n"), 0);
    }
    private function formatYearforUrl(string $date): string
    {
        return substr( date_format(date_create($date),"Y"), 0);
    }

    public function Approve(WorkPlan $workPlan, $status,$year,$month)
    {
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use ($workPlan){
                            $q->where([['name','Action Plan'],['department_id',$workPlan->appliedBy->department_id]]);
                        })->whereDoesntHave('approvals',function ($q) use($workPlan){
                            $q->where('approvable_id',$workPlan->id)
                            ->where('approvable_type',WorkPlan::class);
                        })->orderBy('order_by','asc') ->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

             /* Check Last Approval */
             $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workPlan){
                                    $q->where([['name','Action Plan'],['department_id',$workPlan->appliedBy->department_id]]);
                                })->whereDoesntHave('approvals',function ($q) use($workPlan){
                                        $q->where('approvable_id',$workPlan->id)
                                            ->where('approvable_type',WorkPlan::class);
                                })->orderBy('order_by','desc')->first();

            DB::transaction(function() use ($workPlan, $data, $check_approval){
                $approvalData = $workPlan->approval()->create($data);
                   if($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {

                   }
                    });
                return redirect()->route('construction.planDetails', ['year' => $year, 'month' => $month])->with('message', 'Data has been approved successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
