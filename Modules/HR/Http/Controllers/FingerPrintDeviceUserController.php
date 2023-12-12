<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\FingerPrintDeviceInfo;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrintDeviceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $zk = new ZKTeco('192.168.88.60');
        $zk->connect();
        $zk->enableDevice();
        $users =  $zk->getUser();


        return view('hr::finger-print-device-user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = 'create';
        return view('hr::finger-print-device-user.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {

            // create employee
            $employee = new Employee();
            $employee->emp_name = $request->device_user_name;
            $employee->save();

            $zk = new ZKTeco('192.168.88.60');
            $connected =  $zk->connect();
            $zk->enableDevice();
            $user = $zk->setUser($employee->id, $employee->id, $employee->emp_name, $request->device_user_password);

            return redirect()->route('finger-print-device-users.index');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('hr::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $zk = new ZKTeco('192.168.88.60');
        $connected =  $zk->connect();
        $zk->enableDevice();
        $zk->removeUser($id);
    }
}
