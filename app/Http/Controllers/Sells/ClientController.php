<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Sells\Client;
use App\Sells\Sell;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:client-view|client-create|client-edit|client-delete', ['only' => ['index','show']]);
        $this->middleware('permission:client-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        $clients=Client::latest()->get();
//        $sells=Sell::latest()->get();
        return view('sales/clients.index', compact('clients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $formType = "create";

        return view('sales/clients.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        try{
            $client_data = $request->except('picture','client_profile','auth_picture','nominee_name','age','relation','address','nominee_picture');
//
            $client_data['picture'] = $request->hasFile('picture') ? $request->file('picture')->store('client') : null;
            $client_data['client_profile'] = $request->hasFile('client_profile') ? $request->file('client_profile')->store('client') : null;
            $client_data['auth_picture'] = $request->hasFile('auth_picture') ? $request->file('auth_picture')->store('client') : null;

            $clientNomineeData = array();

            foreach($request->nominee_name as  $key => $data){
                $clientNomineeData[] = [
                    'nominee_name'=>$request->nominee_name[$key],
                    'age'=>$request->age[$key],
                    'relation'=>$request->relation[$key],
                    'address'=>$request->address[$key],
                    'nominee_picture' => $request->hasFile('nominee_picture.'.$key) ? $request->file("nominee_picture")[$key]->store('nominee') : null
                ];

            }
            DB::transaction(function()use($client_data, $clientNomineeData, &$client){
                $client = Client::create($client_data);
                $client->clientNominee()->createMany($clientNomineeData);
            });
            return redirect()->route('clients.index')->with('message', 'Data has been inserted successfully');

//            return redirect()->route('entrySell',$client->id)->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
        return view('sales/clients.show', compact('client'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
//        dd($client->clientNominee);

        $formType = "edit";
        return view('sales/clients.create', compact('formType','client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
//        dd($request->all());
        try{
            $client_data = $request->except('picture','client_profile','auth_picture','nominee_name','age','relation','address','nominee_picture');

            if($request->hasFile('picture')){
                file_exists(asset($client->picture)) && $client->picture ? unlink($client->picture) : null;
                $client_data['picture'] = $request->file('picture')->store('client');
            }
            if($request->hasFile('client_profile')){
                file_exists(asset($client->client_profile)) && $client->client_profile ? unlink($client->client_profile) : null;
                $client_data['client_profile'] = $request->file('client_profile')->store('client');
            }
            if($request->hasFile('auth_picture')){
                file_exists(asset($client->auth_picture)) && $client->auth_picture ? unlink($client->auth_picture) : null;
                $client_data['auth_picture'] = $request->file('auth_picture')->store('client');
            }

            $clientNomineeData = array();
            foreach($request->nominee_name as  $key => $data){
                $clientNomineeData[$key] = [
                    'nominee_name'=>$request->nominee_name[$key],
                    'age'=>$request->age[$key],
                    'relation'=>$request->relation[$key],
                    'address'=>$request->address[$key],
                    'nominee_picture' => $request->hasFile('nominee_picture.'.$key) ? $request->file("nominee_picture")[$key]->store('nominee') : $request->nominee_old_picture[$key],
                ];
            }
//            dd($request->all(), $clientNomineeData);
            DB::transaction(function()use($client,$client_data, $clientNomineeData){
                $client->update($client_data);
                $client->clientNominee()->delete();
                $client->clientNominee()->createMany($clientNomineeData);
            });

            $client->update($client_data);
            return redirect()->route('clients.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        try{
            $client->delete();
            return redirect()->route('clients.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
