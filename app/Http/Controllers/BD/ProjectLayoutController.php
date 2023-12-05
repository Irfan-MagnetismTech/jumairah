<?php

namespace App\Http\Controllers\BD;

use App\BD\BdLeadGeneration;
use App\BD\ProjectLayout;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\ProjectLayoutRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-project-layout-view|bd-project-layout-create|bd-project-layout-edit|bd-project-layout-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-project-layout-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-project-layout-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-project-layout-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bd_lead_locations = BdLeadGeneration::orderBy('id', 'desc')->get();
        return view('bd.project-layout.locations', compact('bd_lead_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bd_lead_location_id)
    {
        $previous_data = ProjectLayout::with('road_details')->where('bd_lead_location_id',$bd_lead_location_id)->get();

        $formType = 'create';
        $projectLayout = ProjectLayout::where('bd_lead_location_id',$bd_lead_location_id)->get();
        $bd_lead_generation = BdLeadGeneration::where('id', $bd_lead_location_id)->first();
        $departments = Department::pluck('name', 'id');
//        dd($bd_lead_generation->BdLeadGenerationDetails->pluck('name')->toArray());
        $lo_nameArr = $bd_lead_generation->BdLeadGenerationDetails->isNotEmpty() ?
                $bd_lead_generation->BdLeadGenerationDetails->pluck('name')->toArray() : [];
           $loName =  implode(',', $lo_nameArr);
//dd($loName);
        return view('bd.project-layout.create', compact('bd_lead_location_id', 'loName','formType', 'bd_lead_generation', 'departments','projectLayout','previous_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectLayoutRequest $request, $bd_lead_location_id)
    {
        try{
            $projectLayoutData  = $request->only('proposed_road_width', 'modified_far', 'total_far', 'proposed_mgc', 'total_basement_floor', 'front_verenda_feet', 'proposed_story','grand_road_sft','grand_far_sft','actual_story','front_ver_spc_per','front_verenda_percent','percentage','side_ver_spc_per');
            $projectLayoutData['bd_lead_location_id'] = $bd_lead_location_id;
            $roadDetails = array();
            foreach($request->road_width as  $key => $data){

                $roadDetails[] = [
                    'existing_road'        =>  $request->existing_road[$key],
                    'proposed_road'        =>  $request->proposed_road[$key],
                    'road_width'        =>  $request->road_width[$key],
                    'land_width'        =>  $request->land_width[$key],
                    'additional_far'    =>  $request->additional_far[$key],
                ];
            }

           DB::transaction(function()use($projectLayoutData, $roadDetails,$bd_lead_location_id){
               $projectLayout = ProjectLayout::updateOrCreate(
                ['bd_lead_location_id' => $bd_lead_location_id],
                $projectLayoutData
            );
            $projectLayout->road_details()->delete();
            $projectLayout->road_details()->createMany($roadDetails);
           });
            return redirect()->route('project-layout.index')->with('message','Information has been inserted successfully');
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
        try{
        $project_layout = ProjectLayout::findOrFail($id);
        $project_layout->delete();
        return redirect()->route('bd_lead_index')->with('message','Information has been deleted successfully');
        }catch(\Exception $err){
            return redirect()->back()->withErrors($err->getMessage());
        }
    }

    public function bd_lead_index(){
        $projectLayout = ProjectLayout::get()->groupBy('bd_lead_location_id');
        $bd_lead_generation = BdLeadGeneration::get()->groupBy('id');
        return view('bd.project-layout.index', compact('bd_lead_generation','projectLayout'));
    }

    /**
     *  Formats the date into y.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr( date_format(date_create($date),"Y-m-d"), 0);
    }
}
