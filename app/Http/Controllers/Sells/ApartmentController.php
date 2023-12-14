<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use App\Project;
use App\ProjectType;
use App\Sells\Apartment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:apartment-view|apartment-create|apartment-edit|apartment-delete', ['only' => ['index','show']]);
        $this->middleware('permission:apartment-create', ['only' => ['create','store']]);
        $this->middleware('permission:apartment-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:apartment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $apartments=Apartment::with('project', 'sell:id,apartment_id')->latest()->get();
        return view('apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $types = [];
        $apartmentType = ['Residential' => 'Residential', 'Commercial' =>'Commercial'];
        $faces = ['East'=>'East','West'=>'West','North'=>'North','South'=>'South','North-East'=>'North-East','North-West'=>'North-West','South-West'=>'South-West','South-East'=>'South-East'];
        return view('apartments.create', compact('apartmentType','formType', 'faces', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        try{
            $apartment_data = $request->all();
            Apartment::create($apartment_data);
            return redirect()->route('apartments.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
        return view('apartments.show', compact('apartment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
//        dd($apartment->face);
        $formType = "edit";
        $apartmentType = ['Residential' => 'Residential', 'Commercial' =>'Commercial'];
        $types = ProjectType::where('project_id', $apartment->project_id)->pluck('type_name', 'composite_key');
        $faces = ['East'=>'East','West'=>'West','North'=>'North','South'=>'South','North-East'=>'North-East','North-West'=>'North-West','South-West'=>'South-West','South-East'=>'South-East'];
        return view('apartments.create', compact('formType', 'apartmentType','faces', 'types', 'apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        try{
            $data = $request->all();
            $apartment->update($data);
            return redirect()->route('apartments.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {

        try{
            if($apartment->sell){
                return back()->withErrors(["This Apartment is already Sold (Sold ID: ".$apartment->sell->id." & Client Name: ".$apartment->sell->client->name."). Please remove the sold information first."]);
            }
            if($apartment->leads->isNotEmpty()){
                return back()->withErrors(["This Apartment has some Lead . Please remove them first."]);
            }
            $apartment->delete();
            return redirect()->route('apartments.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
