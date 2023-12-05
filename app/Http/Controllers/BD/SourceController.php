<?php

namespace App\Http\Controllers\BD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BD\Source;
use Illuminate\Database\QueryException;
use App\Http\Requests\BD\SourceRequest;


class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-source-view|bd-source-create|bd-source-edit|bd-source-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-source-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-source-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-source-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formType = "create";
        $source_data = Source::latest()->get();
        return view('bd.source.create', compact('source_data', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $source_data = Source::latest()->get();
        return view('bd.source.create', compact('source_data', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SourceRequest $request)
    {
        try{
            $data = $request->all();
            Source::create($data);
            return redirect()->route('source.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('source.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(Source $source)
    {
        $formType = "edit";
        $source_data = Source::latest()->get();
        return view('bd.source.create', compact('source', 'source_data', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SourceRequest $request, Source $source)
    {
        try{
            $data = $request->all();
            $source->update($data);
            return redirect()->route('source.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('source.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Source $source)
    {
        try{
            $source->delete();
            return redirect()->route('source.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('source.create')->withErrors($e->getMessage());
        }
    }
}
