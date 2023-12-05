<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Sells\Followup;
use App\Sells\Leadgeneration;
use App\Team;
use App\TeamMember;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamLeader = Team::where('head_id', auth()->id())->first();
        if(auth()->user()->roles->first()->name == 'Sales-HOD'|| auth()->user()->roles->first()->name == 'super-admin'){
            $followups=Followup::whereHas('leadgeneration',function ($q){
                $q->where('lead_stage','!=','D')->where('is_sold',0)->whereDoesntHave('client');
            })->latest()->get();
        }elseif(auth()->user()->head()->exists()){
            $teamMembers = $teamLeader->members()->pluck('member_id','member_id')->toArray();
            array_push($teamMembers,$teamLeader->head_id);
            $followups = Followup::whereHas('leadgeneration',function ($q) use($teamLeader, $teamMembers){
                $q->whereIn('created_by',$teamMembers)
                ->where('lead_stage','!=','D')->where('is_sold',0)->whereDoesntHave('client');
            })->latest()->get();
        }elseif(auth()->user()->member()->exists()){
            $teamMember = TeamMember::where('member_id', auth()->id())->first();
            $followups = Followup::whereHas('leadgeneration',function ($q) use( $teamMember){
                $q->where('created_by',$teamMember->member_id)
                ->where('lead_stage','!=','D')->where('is_sold',0)->whereDoesntHave('client');;
            })->latest()->get();
        }

//        dd($followups);

        return view('sales/followups.index', compact('followups'));
    }

    public function todayFollowups()
    {
        $teamLeader = Team::where('head_id', auth()->id())->first();
        $currentDate = !empty(request()->date) ? date('Y-m-d', strtotime(request()->date)) : date('Y-m-d', strtotime(now()));
        $data =  Leadgeneration::with('apartment.project', 'lastFollowup.followup')
            ->where('lead_stage','!=','D')->where('is_sold',0)
            ->whereHas('lastFollowup', function ($q) use($currentDate){
                $q->where('next_followup_date', $currentDate)->whereDoesntHave('followup');
            })->with(['lastFollowup' => function($q) use($currentDate){
                $q->where('next_followup_date', $currentDate)->whereDoesntHave('followup');
            }])->latest(); 

        if(auth()->user()->roles->first()->name == 'Sales-HOD'|| auth()->user()->roles->first()->name == 'super-admin'){
            $leadgenerations= $data->get(); 
        }elseif(auth()->user()->head()->exists()){  
            $teamMembers = $teamLeader->members()->pluck('member_id')->toArray();
            array_push($teamMembers,$teamLeader->head_id);
            $leadgenerations = $data->whereIn('created_by',$teamMembers)->get();
        }elseif(auth()->user()->member()->exists()){
            $teamMember = TeamMember::where('member_id', auth()->id())->first();
            $leadgenerations = $data->where('created_by',$teamMember->member_id)->get();
        }

        return view('sales.followups.todayFollowups', compact('leadgenerations'));
    }

    public function missedFollowup()
    {
        $teamLeader = Team::where('head_id', auth()->id())->first();
        $currentDate = date('Y-m-d', strtotime(now()));
        $data =  Leadgeneration::with('apartment.project','lastFollowup.followup')
            ->where('lead_stage','!=','D')->where('is_sold',0)
            ->whereHas('lastFollowup', function ($q) use($currentDate){
                $q->where('next_followup_date','<', $currentDate)->whereDoesntHave('followup');
            })
            ->with(['lastFollowup' => function($q) use($currentDate){
                $q->where('next_followup_date','<', $currentDate)->whereDoesntHave('followup');
            }])->latest();
        if(auth()->user()->roles->first()->name == 'Sales-HOD'|| auth()->user()->roles->first()->name == 'super-admin'){
            $leadgenerations= $data->get();
        }elseif(auth()->user()->head()->exists()){
            $teamMembers = $teamLeader->members()->pluck('member_id', 'member_id')->toArray();
            array_push($teamMembers,$teamLeader->head_id);
            $leadgenerations = $data->whereIn('created_by',$teamMembers)->get();
        }elseif(auth()->user()->member()->exists()){
            $teamMember = TeamMember::where('member_id', auth()->id())->first();
            $leadgenerations = $data->where('created_by',$teamMember->member_id)->get();
        }

//        dd($leadgenerations->pluck('lastFollowup')->toArray());

        return view('sales.followups.missedFollowups', compact('leadgenerations'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    public function addfollowup($leadgeneration_id)
    {
        $formType = "create";
        $leadGeneration = Leadgeneration::where('id', $leadgeneration_id)->firstOrFail();
        return view('sales.followups.create', compact('formType', 'leadGeneration'));
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
            $lead = Leadgeneration::where('id',$request->leadgeneration_id)->firstOrFail();
            $followupData = $request->except('leadgeneration_name');
            $followupData['followup_id'] = $lead?->lastFollowup?->id;
            $followupData['user_id'] = auth()->user()->id;
            Followup::create($followupData);
            return redirect()->route('followups.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function show(Followup $followup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function edit(Followup $followup)
    {
        $formType = "edit";
        $leadGeneration = Leadgeneration::where('id', $followup->leadgeneration->id)->firstOrFail();
        return view('sales.followups.create', compact('formType', 'leadGeneration', 'followup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Followup $followup)
    {
        try{
            $followupData = $request->except('leadgeneration_name');
            $followupData['user_id'] = auth()->user()->id;

            $followup->update($followupData);
            return redirect()->route('followups.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Followup $followup)
    {
        try{
            $followup->delete();
            return redirect()->route('followups.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


}
