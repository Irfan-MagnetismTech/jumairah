<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        return view('accounts.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $formType = "create";
        return view('accounts.vehicles.create', compact('formType'));
    }

    public function store(Request $request)
    {
        try{
            $data = $request->all();
            Vehicle::create($data);
            return redirect()->route('vehicles.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('vehicles.create')->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(Vehicle $vehicle)
    {
        //
    }

    public function edit(Vehicle $vehicle)
    {
        $formType = "edit";
        return view('accounts.vehicles.create', compact('formType','vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        try{
            $data = $request->all();
            $vehicle->update($data);
            return redirect()->route('vehicles.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('vehicles.create')->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try{
            $vehicle->delete();
            return redirect()->route('vehicles.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('vehicles.index')->withErrors($e->getMessage());
        }
    }
}
