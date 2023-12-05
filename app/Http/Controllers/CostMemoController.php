<?php

namespace App\Http\Controllers;

use App\CostMemo;
use App\Http\Requests\CostMemoRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostMemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costMemos = CostMemo::get();
        return view('cost-memo.index', compact('costMemos',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('cost-memo.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CostMemoRequest $request)
    {
        try{

            $request_data = $request->only('cost_center_id', 'applied_date');

            $costMemoDetails = array();
            foreach($request->particulers as  $key => $data){
                $costMemoDetails[] = [
                    'particulers'   =>$request->particulers[$key],
                    'amount'        =>$request->amount[$key],
                ];
            }
            DB::transaction(function()use($request_data, $costMemoDetails){
                $costMemo = CostMemo::create($request_data);
                $costMemo->costMemoDetails()->createMany($costMemoDetails);
            });
            return redirect()->route('costMemo.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(CostMemo $costMemo)
    {
        $formType = "edit";
        return view('cost-memo.create', compact('formType', 'costMemo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CostMemoRequest $request, CostMemo $costMemo)
    {
        try{
            $request_data = $request->only('cost_center_id', 'applied_date');

            $costMemoDetails = array();
            foreach($request->particulers as  $key => $data){
                $costMemoDetails[] = [
                    'particulers'   =>$request->particulers[$key],
                    'amount'        =>$request->amount[$key],
                ];
            }
            DB::transaction(function()use($request_data, $costMemoDetails, $costMemo){
                $costMemo->update($request_data);
                $costMemo->costMemoDetails()->delete();
                $costMemo->costMemoDetails()->createMany($costMemoDetails);
            });
            return redirect()->route('costMemo.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(CostMemo $costMemo)
    {
        try{
            $costMemo->delete();
            return redirect()->route('costMemo.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('costMemo.index')->withErrors($e->getMessage());
        }
    }
}
