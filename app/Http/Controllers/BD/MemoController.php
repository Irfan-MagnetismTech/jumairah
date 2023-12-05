<?php

namespace App\Http\Controllers\BD;

use App\BD\Memo;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\MemoRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:memo-view|memo-create|memo-edit|memo-delete', ['only' => ['index','show']]);
        $this->middleware('permission:memo-create', ['only' => ['create','store']]);
        $this->middleware('permission:memo-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:memo-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memos = Memo::get();
        return view('bd.memo.index', compact('memos',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $employees = Employee::select( DB::raw("CONCAT(fname,' ',lname) AS name"),'id')->pluck('name', 'id');
        return view('bd.memo.create', compact('formType', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemoRequest $request)
    {
        try{
            $letter_data = $request->only('letter_date','cost_center_id','employee_id', 'address_word_one','letter_subject','address_word_two','letter_body');

            DB::transaction(function()use($letter_data){
                Memo::create($letter_data);
            });

            return redirect()->route('memo.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(Memo $memo)
    {
        $formType = "edit";
        $employees = Employee::select( DB::raw("CONCAT(fname,' ',lname) AS name"),'id')->pluck('name', 'id');
        return view('bd.memo.create', compact('formType', 'employees', 'memo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemoRequest $request, Memo $memo)
    {
        try{
            $letter_data = $request->only('letter_date','cost_center_id','employee_id', 'address_word_one','letter_subject','address_word_two','letter_body');

            DB::transaction(function()use($letter_data, $memo){
                $memo->update($letter_data);
            });

            return redirect()->route('memo.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(Memo $memo)
    {
        try{
            $memo->delete();
            return redirect()->route('memo.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('memo.create')->withErrors($e->getMessage());
        }
    }
}
