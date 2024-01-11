<?php

namespace App\Http\Controllers\Construction;

use App\Approval\ApprovalLayerDetails;
use App\Construction\MaterialPlan;
use App\Construction\MaterialPlanDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Construction\MaterialPlanRequest;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Construction\MaterialPlanDraftRequest;
use Barryvdh\DomPDF\Facade as PDF;

class MaterialPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:construction-material-plan-view|construction-material-plan-create|construction-material-plan-edit|construction-material-plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:construction-material-plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:construction-material-plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:construction-material-plan-delete', ['only' => ['destroy']]);
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
        $formType       = "create";
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        return view('construction.materialplan.create', compact('projects', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialPlanRequest $request)
    {
        try {
            $materialPlanData = $request->only('project_id', 'from_date', 'to_date');
            $materialPlanData['applied_by'] = auth()->id();
            $materialPlanData['is_saved'] = 1;
            $materialPlanData['year'] = $year = $this->formatYear($request->from_date);
            $materialPlanData['month'] = $month = $this->formatMonth($request->from_date);
            $materialPlanData['gm_approval_status'] = 0;
            $year = $this->formatYearforUrl($request->from_date);
            $month = $this->formatMonthforUrl($request->from_date);
            $materialPlanDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $materialPlanDetailData[] = [
                    'material_id'       =>  $request->material_id[$key],
                    'unit_id'           =>  $request->unit_id[$key],
                    'week_one'          =>  $request->week_one[$key],
                    'week_two'          =>  $request->week_two[$key],
                    'week_three'        =>  $request->week_three[$key],
                    'week_four'         =>  $request->week_four[$key],
                    'remarks'           =>  $request->remarks[$key],
                    'total_quantity'    =>  $request->total_quantity[$key]
                ];
            }
            $materialPlanId = "";
            DB::transaction(function () use ($materialPlanData, $materialPlanDetailData, &$materialPlanId) {
                $materialPlan = MaterialPlan::create($materialPlanData);
                $materialPlan->materialPlanDetails()->createMany($materialPlanDetailData);
                $materialPlanId = $materialPlan->id;
            });
            return redirect()->route('construction.material-budget-details', ['year' =>$year, 'month' =>$month, 'id' => $request->project_id])->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
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
        return view('construction.materialplan.cardyear', compact('years'));
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
        return view('construction.materialplan.monthList', compact('months'));
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
        return view('construction.materialplan.projectList', compact('projects'));
    }

    /**
     * year and monthwise material budget details.
     *@param  Year $year
     *@param  int $month
     * @return \Illuminate\Http\Response
     */
    public function budgetDetails($year, $month, $project_id)
    {
        $currentYearPlans = MaterialPlanDetail::with('materialPlan')
        ->whereHas('materialPlan', function($q)use($year, $month, $project_id){
            return $q->where('year', $year)->where('month', $month)->where('project_id', $project_id)->groupBy('material_plan_id');
        })
        ->get();
        return view('construction.materialplan.index', compact('currentYearPlans', 'year', 'month', 'project_id'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByProjectEng(Request $request)
    {
        // dd($request->id);
        $year = $request->year;
        $month = $request->month;
        $materialPlan = MaterialPlan::where('id', $request->id)->first();
        $currentYearPlans = MaterialPlanDetail::with('materialPlan')
        ->whereHas('materialPlan', function($q)use($year, $month){
            return $q->where('year', $year)->where('month', $month)->groupBy('material_plan_id');
        })
        ->get();
        return view('construction.materialplan.show', compact('currentYearPlans', 'year', 'month'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialPlan $materialPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialPlan $materialPlan)
    {
        $formType       = "edit";
        $projects       = Project::orderBy('name')->pluck('name', 'id');
        return view('construction.materialplan.create', compact('materialPlan', 'projects', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialPlanRequest $request, MaterialPlan $materialPlan)
    {
        try {
            $materialPlanData = $request->only('project_id', 'from_date', 'to_date');
            $materialPlanData['applied_by'] = auth()->id();
            $materialPlanData['is_saved'] = 1;
            $materialPlanData['year'] = $this->formatYear($request->from_date);
            $materialPlanData['month'] = $this->formatMonth($request->from_date);
            $month = $this->formatMonthforUrl($request->from_date);
            $year = $this->formatYearforUrl($request->from_date);
            $materialPlanDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $materialPlanDetailData[] = [
                    'material_id'       =>  $request->material_id[$key],
                    'unit_id'           =>  $request->unit_id[$key],
                    'week_one'          =>  $request->week_one[$key],
                    'week_two'          =>  $request->week_two[$key],
                    'week_three'        =>  $request->week_three[$key],
                    'week_four'         =>  $request->week_four[$key],
                    'remarks'           =>  $request->remarks[$key],
                    'total_quantity'    =>  $request->total_quantity[$key]
                ];
            }
            DB::transaction(function () use (&$materialPlan, $materialPlanData, $materialPlanDetailData) {
                $materialPlan->update($materialPlanData);
                $materialPlan->materialPlanDetails()->delete();
                $materialPlan->materialPlanDetails()->createMany($materialPlanDetailData);
            });

            return redirect()->route('construction.material-budget-details',['year' =>$year, 'month' =>$month, 'id' =>$request->project_id])->with('message', 'Data has been Updated successfully');
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
    public function destroy(MaterialPlan $materialPlan)
    {
        // dd($materialPlan);
    }

    public function MaterialPlanApproved(MaterialPlan $materialPlan, $status)
    {
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use($materialPlan){
                $q->where([['name','Material Plan'],['department_id',$materialPlan->appliedBy->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($materialPlan){
                $q->where('approvable_id',$materialPlan->id)->where('approvable_type',MaterialPlan::class);
            })->orderBy('order_by','asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            $materialPlan->approval()->create($data);

            return redirect()->route('construction.material-budget-details', ['year' =>$materialPlan->year, 'month' =>$materialPlan->month, 'id' =>$materialPlan->project_id])->with('message', "Material Plan has approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    /**
     * pdf for specific month of a year.
     *
     * @param  int  $year $month
     * @return \Illuminate\Http\Response
     */
    public function pdf($year, $month, $project_id)
    {
        $currentYearPlans = MaterialPlanDetail::with('materialPlan')
        ->whereHas('materialPlan', function($q)use($year, $month, $project_id){
            return $q->where('year', $year)->where('month', $month)->where('project_id', $project_id)->groupBy('material_plan_id');
        })
        ->get();
        return PDF::loadview('construction.materialplan.pdf', compact('currentYearPlans'))->setPaper('a4', 'landscape')->stream('material-budget.pdf');
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

    private function formatMonthforUrl(string $date): string
    {
        return substr( date_format(date_create($date),"n"), 0);
    }
    private function formatYearforUrl(string $date): string
    {
        return substr( date_format(date_create($date),"Y"), 0);
    }
    public function DraftSave(MaterialPlanDraftRequest $request){
        try{
        $materialPlanData = $request->only('project_id', 'from_date', 'to_date');
        $materialPlanData['applied_by'] = auth()->id();
        $materialPlanData['year'] = $year = $this->formatYear($request->from_date);
        $materialPlanData['month'] = $month = $this->formatMonth($request->from_date);
        $materialPlanData['gm_approval_status'] = 0;
        $materialPlanData['user_id'] = auth()->user()->id;
        $year = $this->formatYearforUrl($request->from_date);
        $month = $this->formatMonthforUrl($request->from_date);
        $materialPlanDetailData = array();
        foreach ($request->material_id as  $key => $data) {
            $materialPlanDetailData[] = [
                'material_id'       =>  $request->material_id[$key] ?? null,
                'unit_id'           =>  $request->unit_id[$key] ?? null,
                'week_one'          =>  $request->week_one[$key] ?? null,
                'week_two'          =>  $request->week_two[$key] ?? null,
                'week_three'        =>  $request->week_three[$key] ?? null,
                'week_four'         =>  $request->week_four[$key] ?? null,
                'remarks'           =>  $request->remarks[$key] ?? null,
                'total_quantity'    =>  $request->total_quantity[$key] ?? null
            ];
        }
        $materialPlanId = "";

    if(isset($request->draft_id) && $request->draft_id != null){
        $materialPlan = MaterialPlan::findOrFail($request->draft_id);
        DB::transaction(function () use (&$materialPlan, $materialPlanData, $materialPlanDetailData) {
            $materialPlan->update($materialPlanData);
            $materialPlan->materialPlanDetails()->delete();
            $materialPlan->materialPlanDetails()->createMany($materialPlanDetailData);
        });
    }else{
        DB::transaction(function () use ($materialPlanData, $materialPlanDetailData, &$materialPlanId) {
            $materialPlan = MaterialPlan::create($materialPlanData);
            $materialPlan->materialPlanDetails()->createMany($materialPlanDetailData);
            $materialPlanId = $materialPlan->id;
        });
    }
        return redirect()->route('construction.material-budget-details',['year' =>$year, 'month' =>$month, 'id' =>$request->project_id])->with('message', 'Draft has been Updated successfully');
    } catch (QueryException $e) {
        return redirect()->back()->withInput()->withErrors($e->getMessage());
      }
    }
}
