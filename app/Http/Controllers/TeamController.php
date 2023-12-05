<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\TeamRequest;
use App\Team;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:team-view|team-create|team-edit|team-delete', ['only' => ['index','show']]);
        $this->middleware('permission:team-create', ['only' => ['create','store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:team-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $teams = Team::with('members.user')->latest()->paginate();
        return view('sales.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType="create";
        $users = User::latest('name')->pluck('name', 'id');
        return view('sales.teams.create', compact('users','formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        //
        try{
            $team_data = $request->except('member_id');

            $membersData = array();
            foreach($request->member_id as  $key => $data){
                $membersData[] = [
                    'member_id'=>$request->member_id[$key],
                ];
            }

            DB::transaction(function()use($team_data, $membersData){
                $team = Team::create($team_data);
                $team->members()->createMany($membersData);
            });
            return redirect()->route('teams.index')->with('message', 'Data has been inserted successfully');
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
    public function show(Team $team)
    {
        return view('sales.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $formType="edit";
        $teams = Team::latest()->paginate();
        $users = User::latest('name')->pluck('name', 'id');
        return view('sales.teams.create', compact('team', 'teams','users','formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, Team $team)
    {
        //
        try{
            $team_data = $request->except('member_id');

            $membersData = array();
            foreach($request->member_id as  $key => $data){
                $membersData[] = [
                    'member_id'=>$request->member_id[$key],
                ];
            }
            DB::transaction(function()use($team,$team_data, $membersData){
                $team->update($team_data);
                $team->members()->delete();
                $team->members()->createMany($membersData);
            });
            return redirect()->route('teams.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('teams.index')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
        try{
            $team->delete();
            return redirect()->route('teams.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('teams.index')->withErrors($e->getMessage());
        }
    }
}
