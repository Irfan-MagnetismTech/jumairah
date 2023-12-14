<?php

namespace App\Http\Controllers\Procurement;

use App\Boq\Projects\BoqFloorProject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Procurement\BoqSupremeBudget;
use App\CostCenter;
use App\Http\Requests\BoqSupremeBudgetRequest;
use App\Project;
use Illuminate\Database\QueryException;
use App\Procurement\NestedMaterial;
use Illuminate\Support\Facades\DB;

class BoqSupremeBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:boqSupremeBudgets-view|boqSupremeBudgets-create|boqSupremeBudgets-edit|boqSupremeBudgets-delete', ['only' => ['index','show']]);
        $this->middleware('permission:boqSupremeBudgets-create', ['only' => ['create','store']]);
        $this->middleware('permission:boqSupremeBudgets-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:boqSupremeBudgets-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $boq_supreme_budget_data = BoqSupremeBudget::orderBy('id', 'desc')->get();
//        $groupBy_project_id = $boq_supreme_budget_data->groupBy('project_id')->all();
//        return view('procurement.materialbudgets.index', compact('groupBy_project_id'));
//    }

    public function ProjectList($budgetfor)
    {
        $boq_supreme_budget_data = BoqSupremeBudget::orderBy('id', 'desc')->get();
        $groupBy_project_id = $boq_supreme_budget_data->groupBy('project_id')->all();
        return view('procurement.materialbudgets.index', compact('groupBy_project_id','budgetfor'));
    }

    public function budgetList(Request $request)
    {
        // dd($request->all());
        $project = Project::where('id', $request->project_id)->first();
        // dd($project);

        // $total_areas = $project->boqFloorProjects()->sum('area');

        if($project){
            $material_statements = $project->boqSupremeBudgets()->where('budget_type','!=','labour')
                ->where('quantity','!=',0)
                ->groupBy('material_id')
                ->selectRaw('*, SUM(quantity) as gross_total_quantity')
                ->with('nestedMaterial.unit')
                ->get();

            $material_statements = $material_statements->sortBy('nestedMaterial.name');

            // dd($material_statements);
            $material_list = $material_statements;

            // $material_statements if request nested_material_id is not null
            if($request->material_id){
                $material_statements = $material_statements->where('material_id', $request->material_id);
            }

            $floor_wise_group = $material_statements->map(function ($material) use ($project, $request) {
                $floors = $project->boqSupremeBudgets()
                    ->where('material_id', $material->material_id)
                    ->where('budget_type','!=','labour')
                    ->where('budget_for',$request->type)
                    ->where('quantity', '>', 0)
                    ->groupBy('floor_id')
                    ->selectRaw('*, SUM(quantity) as gross_total_quantity')
                    ->with('boqCivilCalcProjectFloor.boqCommonFloor')
                    ->get();

                return [
                    'material_id' => $material?->nestedMaterial?->id,
                    'material_name' => $material?->nestedMaterial?->name,
                    'material_unit' => $material?->nestedMaterial?->unit?->name,
                    'floors' => $floors,
                    'total_quantity' => $floors->sum('gross_total_quantity'),
                ];
            });

            $material_statements = collect($floor_wise_group)->sortBy('floor_id')->values()->all();
        }else{
            $material_statements = null;
            $material_list = null;
        }    
        return view('boq.budget-list.index', compact('material_statements','material_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $projects = Project::orderBy('name')->pluck('name','id');
        $material_layer1 = NestedMaterial::with('unit')->whereNull('parent_id')->pluck('name','id');
        return view('procurement.materialbudgets.create', compact('formType', 'projects','material_layer1'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqSupremeBudgetRequest $request)
    {
        try{
            $materialbudgetdetails_data = array();
            foreach($request->material_id as  $key => $data){
                $materialbudgetdetails_data[] = [
                    'budget_for'    =>  $request->budget_for,
                    'project_id'    =>  $request->project_id,
                    'floor_id'      =>  $request->floor_id[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key],
                    'created_at'    =>  now()
                ];
            }
            DB::transaction(function()use($materialbudgetdetails_data){
                BoqSupremeBudget::insert($materialbudgetdetails_data);
            });
            return redirect()->route('supreme-budget-list',$request->budget_for)->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($project_id)
//    {
//        $boq_supreme_budget_project_data = BoqSupremeBudget::where('project_id', $project_id)->get();
//        $boq_supreme_budget_data = $boq_supreme_budget_project_data->groupBy('floor_id');
//        return view('procurement.materialbudgets.show', compact('boq_supreme_budget_data', 'project_id', 'boq_supreme_budget_project_data'));
//    }

    public function floorWiseSummery($budgetFor, $project_id)
    {
        $floors = BoqFloorProject::where('project_id', $project_id)->get()->pluck('floor.name','boq_floor_project_id');
        $boq_supreme_budget_project_data = BoqSupremeBudget::
            when(!empty(request('floor_id')), function($query){
                $query->where('floor_id', request('floor_id'));
            })
            ->where('project_id', $project_id)->where('budget_for',$budgetFor)
            ->paginate();

        if($boq_supreme_budget_project_data->isNotEmpty()){
            $boq_supreme_budget_data = $boq_supreme_budget_project_data
                    ->setCollection($boq_supreme_budget_project_data->sortBy('nestedMaterial.name')->groupBy('floor_id'));
        }else{
           
            $boq_supreme_budget_data =[];
        };
        $projectName = Project::where('id', $project_id)->first();
        $page = request('page');
        $sl = (!empty($page) && $page != 1) ? (($page - 1) * 15)+1 : 1 ;
        // dd('dfjfd');

        return view('procurement.materialbudgets.show', compact('projectName','floors',
                'boq_supreme_budget_data', 'budgetFor','project_id', 'boq_supreme_budget_project_data','sl'));
    }

    public function material_summery($budgetFor, $project_id)
    {
        $boq_supreme_budget_project_data = BoqSupremeBudget::where('project_id', $project_id)
                    ->where('budget_for',$budgetFor)
                    ->get();

        if($boq_supreme_budget_project_data->isNotEmpty()){
            $boq_supreme_budget_data = BoqSupremeBudget::query()
                    ->join('nested_materials', 'nested_materials.id', '=', 'boq_supreme_budgets.material_id')
                    ->where('project_id', $project_id)
                    ->orderBy('nested_materials.parent_id')
                    ->get()
                    ->groupBy('material_id');
        }else{

            $boq_supreme_budget_data =[];
        };
        $projectName = Project::where('id', $project_id)->first();

        return view('procurement.materialbudgets.material_summery', compact('projectName', 'boq_supreme_budget_data', 'budgetFor','project_id', 'boq_supreme_budget_project_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($project_id)
    // {
    //     $formType = "edit";
    //     $material_layer1 = NestedMaterial::with('unit')->whereNull('parent_id')->pluck('name','id');

    //     $boq_supreme_budget_data = BoqSupremeBudget::with('nestedMaterial')->where('project_id', $project_id)->get();
    //     $projects = CostCenter::whereNotNull('project_id')->pluck('name','project_id');
    //     return view('procurement.materialbudgets.create', compact('formType', 'boq_supreme_budget_data', 'project_id', 'projects','material_layer1'));
    // }

    public function supremeBudgetEdit($budgetFor, $project_id)
    {
        $formType = "edit";
        $material_layer1 = NestedMaterial::with('unit')->whereNull('parent_id')->pluck('name','id');

        $boq_supreme_budget_data = BoqSupremeBudget::with('nestedMaterial')
            ->where('budget_for',$budgetFor)
            ->where('project_id', $project_id)->get();
        $projects = CostCenter::whereNotNull('project_id')->pluck('name','project_id');
        return view('procurement.materialbudgets.create', compact('budgetFor', 'formType', 'boq_supreme_budget_data', 'project_id', 'projects','material_layer1'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supremeBudgetUpdate(BoqSupremeBudgetRequest $request, $budgetFor,  $project_id)
    {
        try{
            $materialbudgetdetails_data = array();
            foreach($request->material_id as  $key => $data){
                $materialbudgetdetails_data[] = [
                    'budget_for'    =>  $budgetFor,
                    'project_id'    =>  $request->project_id,
                    'floor_id'      =>  $request->floor_id[$key],
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key],
                    'created_at'    => now(),
                    'updated_at'    => now()
                ];
            }
            DB::transaction(function()use($materialbudgetdetails_data, $project_id){
                BoqSupremeBudget::where('project_id', $project_id)->delete($project_id);
                BoqSupremeBudget::insert($materialbudgetdetails_data);
            });
            return redirect()->route('supreme-budget-list',$budgetFor)->with('message', 'Data has been updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id)
    {
        try{
            BoqSupremeBudget::where('project_id', $project_id)->delete($project_id);
            return redirect()->route('boqSupremeBudgets.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('boqSupremeBudgets.index')->withErrors($e->getMessage());
        }
    }


}
