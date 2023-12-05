<?php

namespace App\Http\Controllers\Boq\Departments\Sanitary;

use App\Boq\Departments\Sanitary\ProjectWiseLaborCost;
use App\Boq\Departments\Sanitary\SanitaryLaborCost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\ProjectWiseLaborCostRequest;
use App\Procurement\Unit;
use App\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectWiseLaborCostController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:boq-sanitary', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $ProjectWiseLaborCostData = ProjectWiseLaborCost::get();
        return view('boq.departments.sanitary.project-wise-labor-cost.index', compact('ProjectWiseLaborCostData', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $units = Unit::orderBy('id')->pluck('name', 'id');
        $laborCostDetails = SanitaryLaborCost::orderBy('id')->get();
        return view('boq.departments.sanitary.project-wise-labor-cost.create', compact('units', 'laborCostDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectWiseLaborCostRequest $request, Project $project)
    {
        try{
            $ProjectWiseLaborCostData = array();
            foreach($request->labor_cost_id as  $key => $data){
                $ProjectWiseLaborCostData[] = [
                    'project_id'        =>  $project->id,
                    'labor_cost_id'     =>  $request->labor_cost_id[$key],
                    'quantity'          =>  $request->quantity[$key],
                    'user_id'           =>  auth()->user()->id,
                    'created_at'        =>  now(),
                ];
            }
            DB::transaction(function()use($ProjectWiseLaborCostData){
                ProjectWiseLaborCost::insert($ProjectWiseLaborCostData);
            });

            return redirect()->route('boq.project.departments.sanitary.project-wise-labor-cost.index',$project)->with('message', 'Data has been inserted successfully');
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
