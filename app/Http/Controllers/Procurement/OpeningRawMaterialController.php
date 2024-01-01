<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\OpeningRawMaterialRequest;
use App\Procurement\OpeningRawMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningRawMaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:opening-stock-view|opening-stock-create|opening-stock-edit|opening-stock-delete', ['only' => ['index','show', 'getmaterialmovementsPdf', 'movmentOutApproval']]);
        $this->middleware('permission:opening-stock-create', ['only' => ['create','store']]);
        $this->middleware('permission:opening-stock-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:opening-stock-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $OpeningRawMaterials = OpeningRawMaterial::get();
        return view('procurement.opening-raw-material.index', compact('OpeningRawMaterials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType     = "create";
        return view('procurement.opening-raw-material.create', compact('formType'));
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
            $requestData = $request->only('cost_center_id');
            $requestData['entry_by'] = auth()->id();
            $requestData['applied_date'] = $this->formatDate($request->applied_date);

            $requestDetails = array();
            foreach($request->material_id as  $key => $data){
                $requestDetails[] = [
                    'material_id'     =>$request->material_id[$key],
                    'quantity'        =>$request->quantity[$key]
                ];
            }

            DB::transaction(function()use($requestData, $requestDetails){
                $OpeningRawMaterial = OpeningRawMaterial::create($requestData);
                $OpeningRawMaterial->OpeningRawMaterialDetails()->createMany($requestDetails);
            });

            return redirect()->route('opening-material.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(OpeningRawMaterial $openingMaterial)
    {
        $formType     = "edit";
        return view('procurement.opening-raw-material.create', compact('formType','openingMaterial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpeningRawMaterial $openingMaterial)
    {
        try{
            $requestData = $request->only('cost_center_id');
            $requestData['applied_date'] = $this->formatDate($request->applied_date);

            $requestDetails = array();
            foreach($request->material_id as  $key => $data){
                $requestDetails[] = [
                    'material_id'     =>$request->material_id[$key],
                    'quantity'        =>$request->quantity[$key]
                ];
            }

            DB::transaction(function()use($requestData, $requestDetails, $openingMaterial){
                $openingMaterial->update($requestData);
                $openingMaterial->OpeningRawMaterialDetails()->delete();
                $openingMaterial->OpeningRawMaterialDetails()->createMany($requestDetails);
            });

            return redirect()->route('opening-material.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
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

    /**
     *  Formats the date into y-m.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr( date_format(date_create($date),"y-m-d"), 0);
    }
}
