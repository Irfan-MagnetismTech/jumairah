<?php

namespace App\Http\Controllers;

use App\Accounts\BalanceAndIncomeLine;
use App\CogsGroup;
use App\Department;
use App\Designation;
use App\District;
use App\Division;
use App\Http\Requests\ProjectRequest;
use App\Project;
use App\Sells\Apartment;
use App\Thana;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:project-view|project-create|project-edit|project-delete', ['only' => ['index','show']]);
        $this->middleware('permission:project-create', ['only' => ['create','store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $projects=Project::latest()->get();
        return view('sales/projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $category = ['Residential'=>'Residential','Commercial'=>'Commercial','Residential cum Commercial'=>'Residential cum Commercial'];
        return view('sales/projects.create', compact('formType','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        try{
        //    dd($request->all());
            $project_data = $request->except('type_name', 'size','agreement','floor_plan','others','photo','nid','tin','doa','poa','khajna_receipt','khatiyan','warishion_certificate','luc','cda','nec','electricity_bill','wasa_billl','holding_tex','gas_bill');
            $project_data['agreement'] = $request->hasFile('agreement') ? $request->file('agreement')->store('project') : null;
            $project_data['floor_plan'] = $request->hasFile('floor_plan') ? $request->file('floor_plan')->store('project') : null;
            $project_data['others'] = $request->hasFile('others') ? $request->file('others')->store('project') : null;

            $cogsLine['line_text']= 'COGS - '.$request->name;
            $cogsLine['line_type']= 'income_line';
            $cogsLine['value_type']= 'D';
            $cogsLine['parent_id']= 75;

            $salesLine['line_text']= 'Sale - '.$request->name;
            $salesLine['line_type']= 'income_line';
            $salesLine['value_type']= 'C';
            $salesLine['parent_id']= 49;

            $accountGroups = CogsGroup::get();

            DB::transaction(function()use($project_data, $cogsLine, $salesLine, $accountGroups, $request){
                $project = Project::create($project_data);
                $project->costCenter()->create(['name'=>$project->name, 'shortName'=>$project->shortName]);
                $line = $project->balanceIncomeLine()->create($cogsLine);
                $project->balanceIncomeLine()->create($salesLine);
                $i=1; $accountData=[];
                foreach ($accountGroups as $accountGroup){
                    $sl = $i++;
                    $accountData[] = ['account_name' => "$accountGroup->name COGS -" .$request->name,
                                    'account_type' => '5',
                                    'account_code' => "74-75-$line->id-$sl",
                                    'balance_and_income_line_id' => $line->id,
                                    'group' => $accountGroup->id,
                        ];
                }
                $project->accounts()->createMany($accountData);

                $project->projectType()->createMany(
                    collect(request()->type_name)->map(function($item, $key)use($project){
                        return [
                            'type_name'=>request()->type_name[$key],
                            'size'=>request()->size[$key],
                            'composite_key'=>$project->id.request()->type_name[$key],
                        ];
                    })->toArray()
                );
            });

            return redirect()->route('projects.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $inventories = Apartment::with('project', 'sell')->where('project_id', $project->id)->where('owner', 1)->get();
        $project = Project::with('apartments.sell.sellClient.client', 'parkings.parkingDetails.soldParking')->where('id', $project->id)->firstOrFail();
        $apartments = Apartment::where('apartment_type','Commercial')->where('project_id',$project->id);
        $commercialApartments = $apartments->orderBy('floor','desc')->get()->groupBy('floor');
        if ($apartments->get()->isNotEmpty()){
            $maxValue = max($apartments->groupBy('floor')->select(DB::raw('count(*) as total'))->get()->pluck('total')->toArray());
        }else{
            $maxValue =0;
        }
//        dd($commercialApartments->toArray());
        return view('sales/projects.show', compact('project', 'maxValue','commercialApartments','inventories'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $formType = "edit";
        $category = ['Residential'=>'Residential','Commercial'=>'Commercial','Residential cum Commercial'=>'Residential cum Commercial'];
        return view('sales/projects.create', compact('formType','project','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try{
        // dd($request->all());
        //            dd($project->agreement);
            $project_data = $request->except('type_name', 'size', 'agreement','floor_plan','others','photo','nid','tin','doa','poa','khajna_receipt','khatiyan','warishion_certificate','luc','cda','nec','electricity_bill','wasa_billl','holding_tex','gas_bill');

            if($request->hasFile('agreement')){
                file_exists(asset($project->agreement)) && $project->agreement ? unlink($project->agreement) : null;
                $project_data['agreement'] = $request->file('agreement')->store('project');
            }
            if($request->hasFile('floor_plan')){
                file_exists(asset($project->floor_plan)) && $project->floor_plan ? unlink($project->floor_plan) : null;
                $project_data['floor_plan'] = $request->file('floor_plan')->store('project');
            }
            if($request->hasFile('others')){
                file_exists(asset($project->others)) && $project->others ? unlink($project->others) : null;
                $project_data['others'] = $request->file('others')->store('project');
            }

            $cogsLine['line_text']= 'COGS - '.$request->name;
            $cogsLine['line_type']= 'income_line';
            $cogsLine['value_type']= 'D';
            $cogsLine['parent_id']= 75;

            $salesLine['line_text']= 'Sale - '.$request->name;
            $salesLine['line_type']= 'income_line';
            $salesLine['value_type']= 'C';
            $salesLine['parent_id']= 49;

            DB::transaction(function()use($project,$project_data, $cogsLine, $salesLine, $request){
                $project->update($project_data);
                $project->projectType()->delete();

                $project->balanceIncomeLine()->updateOrCreate(['parent_id' => 49, 'project_id'=>$project->id], $salesLine);
                $line  = $project->balanceIncomeLine()->updateOrCreate(['parent_id' => 75, 'project_id'=>$project->id], $cogsLine);

                $i=1;
                $accountGroups = CogsGroup::get();
                $projectAccounts = $project->accounts()->get();
                if($project->accounts->isNotEmpty()){
                    foreach ($projectAccounts as $projectAccount){
                        $projectnameArray = explode('-', $projectAccount->account_name);
                        $projectAccount->update(['account_name' => $projectnameArray[0]. ' -'.$project->name]);
                    }
                }else{
                    foreach ($accountGroups as $accountGroup){
                        $sl = $i++;
                        $accountData = ['account_name' => "$accountGroup->name COGS -" .$project->name,
                            'account_type' => '5',
                            'account_code' => "74-75-$line->id-$sl",
                            'balance_and_income_line_id' => $line->id,
                            'group' => $accountGroup->id,
                        ];
                        $project->accounts()->create($accountData);
                    }
                }
                $project->costCenter()->update( ['name'=>$project->name, 'shortName'=>$project->shortName]);

                $project->projectType()->createMany(
                    collect(request()->type_name)->map(function($item, $key)use($project){
                        return [
                            'type_name'=>request()->type_name[$key],
                            'size'=>request()->size[$key],
                            'composite_key'=>$project->id.request()->type_name[$key],
                        ];
                    })->toArray()
                );
            });

            return redirect()->route('projects.index')->with('message', 'Data has been Updated successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        try{
            if($project->apartments->isNotEmpty()){
                return back()->withErrors(["This Project has some Apartments. Please remove them first."]);
            }
            if($project->parkings->isNotEmpty()){
                return back()->withErrors(["This Project has some Parking. Please remove them first."]);
            }
            if ($project->costCenter->ledgers->isNotEmpty()) {
                return back()->withErrors(["This Project has some Ledgers. Please remove them first."]);
            }
             if ($project->ledgers->isNotEmpty()){
                return back()->withErrors(["This Project has some Ledgers. Please remove them first."]);
             }
            $project->costCenter()->delete();
            $project->balanceIncomeLine()->delete();
            $project->accounts()->delete();
            $project->delete();

            return redirect()->route('projects.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return back()->withErrors($e->getMessage());
        }
    }
}
