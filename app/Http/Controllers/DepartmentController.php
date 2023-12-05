<?php

namespace App\Http\Controllers;

use App\Apsection;
use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;

class DepartmentController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:department-view|department-create|department-edit|department-delete', ['only' => ['index','show']]);
        $this->middleware('permission:department-create', ['only' => ['create','store']]);
        $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $departments = Department::withCount('employees')->latest()->get(); 

        // dd($departments->toArray());
        return view('departments.create', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::withCount('employees')->latest()->paginate();
        return view('departments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try{
            $data = $request->all();
            Department::create($data);
            return redirect()->route('departments.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $departments = Department::withCount('employees')->latest()->paginate();
        return view('departments.create', compact('department', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        try{
            $data = $request->all();
            $department->update($data);
            return redirect()->route('departments.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('departments.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try{
            if($department->employees->isNotEmpty()){
                return back()->withErrors(["There are some Employees who belongs this Department. Please remove them first."]);
            }
            $department->delete();
            return redirect()->route('departments.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('departments.create')->withErrors($e->getMessage());
        }
    }
}
