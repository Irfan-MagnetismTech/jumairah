<?php

namespace App\Http\Controllers\Boq;

use App\Boq\MaterialServicing;
use App\Http\Controllers\Controller;
use App\Http\Requests\Boq\MaterialServicingRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialServicingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:material-servicing-view|material-servicing-create|material-servicing-edit|material-servicing-delete', ['only' => ['index','show']]);
        $this->middleware('permission:material-servicing-create', ['only' => ['create','store']]);
        $this->middleware('permission:material-servicing-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:material-servicing-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MaterialServicing = MaterialServicing::get()->groupBy(['material_id','fixed_asset_id']);
        return view('boq.material-servicing.index', compact('MaterialServicing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('boq.material-servicing.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialServicingRequest $request)
    {
        try{
            $requestData = array();
            foreach($request->material_id as  $key => $data){

                $requestData[] = [
                    'material_id'       =>  $request->material_id[$key],
                    'fixed_asset_id'    =>  $request->fixed_asset_id[$key],
                    'servicing_status'  =>  1,
                    'present_status'    =>  $request->present_status[$key],
                    'servicing_date'    =>  $request->servicing_date[$key],
                    'comment'           =>  $request->comment[$key],
                    'created_at'        =>  now()
                ];
            }

           DB::transaction(function()use($requestData){
               $requisition = MaterialServicing::insert($requestData);
           });

            return redirect()->route('boq.MaterialServincing.index')->with('message', 'Data has been inserted successfully');
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
        //
    }
}
