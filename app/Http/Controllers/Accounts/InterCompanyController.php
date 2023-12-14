<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\InterCompany;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class InterCompanyController extends Controller
{

    public function index()
    {
        $interCompanies = InterCompany::latest()->get();
        return view('accounts.intercompanies.index', compact('interCompanies'));
    }

    public function create()
    {
        $formType = "create";
        return view('accounts.intercompanies.create', compact('formType'));
    }

    public function store(Request $request)
    {
        try{
            $data = $request->all();
            InterCompany::create($data);
            return redirect()->route('intercompanies.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('intercompanies.index')->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(InterCompany $interCompany)
    {
        //
    }

    public function edit(InterCompany $interCompany)
    {
        $formType = "edit";
        return view('accounts.intercompanies.create', compact('formType', 'interCompany'));
    }


    public function update(Request $request, InterCompany $interCompany)
    {

        try{
            $data = $request->all();
            $interCompany->update($data);
            return redirect()->route('intercompanies.index')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('intercompanies.index')->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(InterCompany $interCompany)
    {
        try{
            $interCompany->delete();
            return redirect()->route('intercompanies.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('intercompanies.index')->withErrors($e->getMessage());
        }
    }
}
