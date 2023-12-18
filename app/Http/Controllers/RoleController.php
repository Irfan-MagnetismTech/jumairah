<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class RoleController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:role-view|role-create|role-edit|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name', 'ASC')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $permissions = Permission::orderBy('name')->get()->groupBy(['module','subject'])
                    ;
        // dd($permissions); 
        return view('roles.create', compact( 'permissions'));
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
                    'name' => 'required|unique:roles,name',
                    'permission' => 'required',
                ]
            );
            $userRole = Role::create(['name'=>$request->name]);
            $userRole->syncPermissions([$request->permission]);
            return redirect()->route('roles.index')->with('success', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissions = $role->getPermissionNames();
        return view('roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $formType = "edit";
        $permission = Permission::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(['module','subject']);

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('roles.create',compact('role','permission','permissions','rolePermissions','formType'));
    }

    public function update(Request $request, Role $role)
    {
        try{
            $this->validate($request,
                [
                    'name' => 'required',
                    'permission' => 'required',
                ]
            );

            $role->update(['name'=>$request->name]);
            $role->syncPermissions($request->permission);
            return redirect()->route('roles.index')->with('success', 'Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try{
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
