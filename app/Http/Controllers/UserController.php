<?php

namespace App\Http\Controllers;

use App\Apsection;
use App\CostCenter;
use App\Department;
use App\Employee;
use App\Http\Requests\UserRequest;

//use Illuminate\Foundation\Auth\User;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use App\Services\UploadService;

class UserController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:user-view|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::latest()->with('roles', 'employee')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";

        $roles = Role::query()
            ->when(auth()->user()->hasRole('super-admin'), function ($query) {
                return $query;
            })
            ->when(auth()->user()->hasRole('admin'), function ($query) {
                return $query->where('name', '!=', 'super-admin');
            })
            ->orderBy('name')
            ->pluck('name', 'id');

        $departments = Department::orderBy('name')->pluck('name', 'id');
        $employees = Employee::orderBy('emp_name')->get(['emp_name', 'id', 'emp_code']);
        $costCenter = CostCenter::query()->whereNotNull('project_id')->pluck('name', 'id');
        return view('users.create', compact('formType', 'roles', 'employees', 'departments', 'costCenter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $file = $request->file('signature');
            if ($file) {
                $dimensions = getimagesize($file);
            } else {
                $dimensions = ['null', 'null'];
            }
            $this->validate($request, [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'signature' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=400,min_height=300|max:2048'
            ], [
                'signature.dimensions' => "The signature dimensions must be at least 400 * 300 pixels but the images dimention is {$dimensions[0]} x {$dimensions[1]} pixels."
            ]);

            DB::beginTransaction();
            $input = $request->only('cost_center_id');
            $assigenedProject = [];

            if (isset($input['cost_center_id']) && is_array($input['cost_center_id'])) {
                foreach ($input['cost_center_id'] as $projectId) {
                    $assigenedProject[] = ['cost_center_id' => $projectId];
                }
            }

            $input = $request->all();
            $input['password'] = Hash::make($request['password']);
            if ($request->file('signature')) {
                $input['signature'] = (new UploadService())->handleFile($request->file('signature'), 'img');
            }
            $user = User::create($input);
            $user->assignRole($request->input('role'));
            if ($request->project_assigned == 1) {
                $user->assignedProject()->createMany($assigenedProject);
            }
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (QueryException $e) {
            if ($file) {
                (new UploadService())->deleteFile($input['signature']);
            }
            DB::rollback();
            return redirect()->route('users.edit')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $formType = "edit";
        $roles = Role::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');

        $employees = Employee::orderBy('emp_name')->get(['emp_name', 'id', 'emp_code']);
        $costCenter = CostCenter::query()->whereNotNull('project_id')->pluck('name', 'id');
        return view('users.create', compact('formType', 'roles', 'employees', 'user', 'departments', 'costCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  object  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $file = $request->file('signature');
            if ($file) {
                $dimensions = getimagesize($file);
            } else {
                $dimensions = ['null', 'null'];
            }

            $this->validate($request, [
                'signature' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=400,min_height=300|max:2048'
            ], [
                'signature.dimensions' => "The signature dimensions must be at least 400 * 300 pixels but the images dimention is {$dimensions[0]} x {$dimensions[1]} pixels."
            ]);

            DB::beginTransaction();
            $input = $request->only('cost_center_id');
            $assigenedProject = [];

            if (isset($input['cost_center_id']) && is_array($input['cost_center_id'])) {
                foreach ($input['cost_center_id'] as $projectId) {
                    $assigenedProject[] = ['cost_center_id' => $projectId];
                }
            }
            $userData = $request->all();
            if (!empty($userData['password'])) {
                $userData['password'] = Hash::make($request['password']);
            } else {
                $userData['password'] = $user->password;
            }
            if ($file) {
                $userData['signature'] = (new UploadService())->handleFile($request->file('signature'), 'img', $user->signature);
            }
            if (!($request->project_assigned)) {
                $userData['project_assigned'] = 0;
            }
            $user->update($userData);
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($userData['role']);
            $user->assignedProject()->delete();
            if ($request->project_assigned == 1) {
                $user->assignedProject()->createMany($assigenedProject);
            }
            DB::commit();
            //            $user->assignRole($request->input('role'));
            return redirect()->route('users.index')->with('success', 'User Updated successfully');
        } catch (QueryException $e) {
            if ($file) {
                (new UploadService())->deleteFile($userData['signature']);
            }
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            (new UploadService())->deleteFile($user['signature']);
            return redirect()->route('users.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
