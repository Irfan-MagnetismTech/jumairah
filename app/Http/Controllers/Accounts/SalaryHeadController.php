<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\SalaryHead;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalaryHeadRequest;
use App\Http\Requests\UpdateSalaryHeadRequest;
use Illuminate\Database\QueryException;

class SalaryHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heads = SalaryHead::latest()->get();
        return view('accounts.salary-heads.create', compact('heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heads = SalaryHead::latest()->get();
        return view('accounts.salary-heads.create', compact('heads'));
    }

    public function store(StoreSalaryHeadRequest $request)
    {
        try{
            $data = $request->all();
            SalaryHead::create($data);
            return redirect()->route('salary-heads.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(SalaryHead $salaryHead)
    {
        //
    }

    public function edit(SalaryHead $salaryHead)
    {
        $heads = SalaryHead::latest()->get();
        return view('accounts.salary-heads.create', compact('heads','salaryHead'));
    }

    public function update(StoreSalaryHeadRequest $request, SalaryHead $salaryHead)
    {
        try{
            $data = $request->all();
            $salaryHead->update($data);
            return redirect()->route('salary-heads.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(SalaryHead $salaryHead)
    {
        try{
            $salaryHead->delete();
            return redirect()->route('salary-heads.create')->with('message', 'Data has been Deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('salary-heads.create')->withInput()->withErrors($e->getMessage());
        }
    }
}
