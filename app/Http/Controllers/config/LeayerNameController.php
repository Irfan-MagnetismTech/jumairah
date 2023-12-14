<?php

namespace App\Http\Controllers\config;

use App\Config\LeayerName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use App\Http\Requests\Config\LeayerNameRequest;

class LeayerNameController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:approval-layer-subject', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formType = "create";
        $leayer_name_data = LeayerName::latest()->get();
        return view('config.leayer_name.create', compact('leayer_name_data', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $leayer_name_data = LeayerName::latest()->get();
        return view('config.leayer_name.create', compact('leayer_name_data', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeayerNameRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:leayer_names',
        ]);

        try {
            $data = $request->all();
            LeayerName::create($data);
            return redirect()->route('leayer-name.create')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('leayer-name.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(LeayerName $leayer_name)
    {
        $formType = "edit";
        $leayer_name_data = LeayerName::latest()->get();
        return view('config.leayer_name.create', compact('leayer_name', 'leayer_name_data', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeayerNameRequest $request, LeayerName $leayer_name)
    {
        $validated = $request->validate([
            'name' => 'required|unique:leayer_names',
        ]);

        try {
            $data = $request->all();
            $leayer_name->update($data);
            return redirect()->route('leayer-name.create')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('leayer-name.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeayerName $leayer_name)
    {
        try {
            $leayer_name->delete();
            return redirect()->route('leayer-name.create')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('leayer-name.create')->withErrors($e->getMessage());
        }
    }
}
