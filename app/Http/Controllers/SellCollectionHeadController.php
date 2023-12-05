<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellCollectionHeadRequest;
use App\SellCollectionHead;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SellCollectionHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
        $this->middleware('permission:sellCollectionHead-view|sellCollectionHead-create|sellCollectionHead-edit|sellCollectionHead-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sellCollectionHead-create', ['only' => ['create','store']]);
        $this->middleware('permission:sellCollectionHead-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sellCollectionHead-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $sellCollectionHeads = SellCollectionHead::latest()->paginate();
        return view('sales.sellCollectionHeads.create', compact('sellCollectionHeads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sellCollectionHeads = SellCollectionHead::latest()->paginate();
        return view('sales.sellCollectionHeads.create', compact('sellCollectionHeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellCollectionHeadRequest $request)
    {
        //
        try{
            $data = $request->all();
            SellCollectionHead::create($data);
            return redirect()->route('sellCollectionHeads.create')->with('message', 'Data has been inserted successfully');
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
    public function edit(SellCollectionHead $sellCollectionHead)
    {
        //
        $sellCollectionHeads = SellCollectionHead::latest()->paginate();
        return view('sales.sellCollectionHeads.create', compact('sellCollectionHead', 'sellCollectionHeads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellCollectionHeadRequest $request, SellCollectionHead $sellCollectionHead)
    {
        //
        try{
            $data = $request->all();
            $sellCollectionHead->update($data);
            return redirect()->route('sellCollectionHeads.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('sellCollectionHeads.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SellCollectionHead $sellCollectionHead)
    {
        //

        try{

            $sellCollectionHead->delete();
            return redirect()->route('sellCollectionHeads.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('sellCollectionHeads.create')->withErrors($e->getMessage());
        }

    }
}
