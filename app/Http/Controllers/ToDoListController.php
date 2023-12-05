<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoListRequest;
use App\ToDoList;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    function __construct()
//    {
//        $this->middleware('permission:toDoList-view|toDoList-create|toDoList-edit|toDoList-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:toDoList-create', ['only' => ['create','store']]);
//        $this->middleware('permission:toDoList-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:toDoList-delete', ['only' => ['destroy']]);
//    }
    public function index()
    {
        $formType="";
        $to_do_lists = ToDoList::latest()->where('user_id', Auth::id())->paginate();
        return view('sales.to_do_lists.create', compact('to_do_lists','formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType="";
        $to_do_lists = ToDoList::latest()->paginate();
        return view('sales.to_do_lists.create', compact('to_do_lists','formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToDoListRequest $request)
    {
        try{
            $data = $request->all();
            $data['user_id'] =Auth::user()->id;
            $data['creating_date'] =Carbon::now()->format('d-m-Y');
            $data['status'] ="Pending";
            ToDoList::create($data);
            return redirect()->route('to_do_lists.create')->with('message', 'Data has been inserted successfully');
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
    public function edit(ToDoList $to_do_list)
    {
        $formType="edit";
        $to_do_lists = ToDoList::latest()->paginate();
        return view('sales.to_do_lists.create', compact('to_do_list', 'to_do_lists', 'formType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ToDoListRequest $request, ToDoList $to_do_list)
    {
        try{

            $data = $request->all();
            $data['user_id'] =Auth::user()->id;
            if($request->completion_date){
                $data['status'] ="Done";
            }
            else{
                $data['completion_date'] = $request->completion_date ? $request->completion_date : null;
                $data['status'] ="Pending";
            }
//            dd($data);
            $to_do_list->update($data);
            return redirect()->route('to_do_lists.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('to_do_lists.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoList $to_do_list)
    {
        //
        try{
            $to_do_list->delete();
            return redirect()->route('to_do_lists.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('to_do_lists.create')->withErrors($e->getMessage());
        }

    }
}
