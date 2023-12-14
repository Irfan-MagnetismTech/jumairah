<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Sells\Saleactivity;
use App\Sells\Sell;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SaleactivityController extends Controller
{

    public function index(){
        $saleactivities=Saleactivity::with('sell')->latest()->get();
        return view('sales/saleactivities.index', compact('saleactivities'));
    }

    public function create()
    {
        abort(404);
    }

    public function addsaleactivity($sell_id)
    {
        $formType = "create";
        $sell = Sell::where('id', $sell_id)->firstOrFail();
        return view('sales/saleactivities.create', compact('formType', 'sell'));
    }

    public function store(Request $request)
    {
        try{
            $saleactivityData = $request->except('client_name');
            Saleactivity::create($saleactivityData);
            return redirect()->route('saleactivities.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(Saleactivity $saleactivity)
    {

    }

    public function edit(Saleactivity $saleactivity)
    {
        $formType = "edit";
        $sell = Sell::where('id', $saleactivity->sell_id)->firstOrFail();
        return view('sales/saleactivities.create', compact('formType', 'sell', 'saleactivity'));
    }

    public function update(Request $request, Saleactivity $saleactivity)
    {
        try{
            $saleactivityData = $request->except('client_name');
            $saleactivity->update($saleactivityData);
            return redirect()->route('saleactivities.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function destroy(Saleactivity $saleactivity)
    {
        try{
            $saleactivity->delete();
            return redirect()->route('saleactivities.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
