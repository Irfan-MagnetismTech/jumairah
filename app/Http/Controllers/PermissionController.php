<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class PermissionController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:permission-view|permission-create|permission-edit|permission-delete', ['only' => ['index','show']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::latest()->get();
        $modules = config('company_info.modules');
        $subjects = [];
        $formType = "create";
        return view('permissions.create', compact('modules','subjects','permissions', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $permissions = Permission::latest()->get();
        $modules = config('company_info.modules');
        $subjects = [];
        return view('permissions.create', compact('modules','subjects','permissions', 'formType'));
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
            $this->validate($request,
                [
                    'name' => 'required|unique:permissions,name',
                ]
            );
            $data = $request->all();
            Permission::create($data);
            return redirect()->route('permissions.create')->with('message', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->route('permissions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $formType = "edit";
        $permissions = Permission::latest()->get();
        $modules = config('company_info.modules');
        $subjects = [];
        return view('permissions.create', compact('modules','subjects','permission', 'permissions', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        try{
            $data = $request->all();
            $permission->update($data);
            return redirect()->route('permissions.create')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->route('permissions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        try{
            $permission->delete();
            return redirect()->route('permissions.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('permissions.create')->withErrors($e->getMessage());
        }
    }
}
