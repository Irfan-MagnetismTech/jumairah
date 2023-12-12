<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\FingerPrintDeviceInfo;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrintDeviceInfoController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('fingerprint-device-show');
        $devices = FingerPrintDeviceInfo::all();

        return view('hr::device.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('fingerprint-device-create');
        $formType = 'create';
        return view('hr::device.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('fingerprint-device-create');

            $input = $request->all();
            $zk = new ZKTeco($input['device_ip']);
            $zk->connect();
            $zk->enableDevice();
            $input['device_serial'] = substr($zk->serialNumber(), 14);
            $input['device_name'] = substr($zk->deviceName(), 12);

            DB::transaction(function () use ($input, $request) {
                FingerPrintDeviceInfo::create($input);
            });
            return redirect()->route('finger-print-device-infos.index')->with('message', 'Device Info created successfully.');
        } catch (QueryException $e) {
            return redirect()->route('finger-print-device-infos.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->authorize('fingerprint-device-show');
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('fingerprint-device-edit');

        $device = FingerPrintDeviceInfo::find($id);
        $formType = 'edit';
        return view('hr::device.create', compact('device', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            $this->authorize('fingerprint-device-edit');

            $input = $request->all();
            $zk = new ZKTeco($input['device_ip']); // 163.47.87.233
            $zk->connect();
            $zk->enableDevice();
            $input['device_serial'] = substr($zk->serialNumber(), 14);
            $input['device_name'] = substr($zk->deviceName(), 12);
            DB::transaction(function () use ($input, $request, $id) {
                FingerPrintDeviceInfo::find($id)->update($input);
            });
            return redirect()->route('finger-print-device-infos.index')->with('message', 'Device Info updated successfully.');
        } catch (QueryException $e) {
            return redirect()->route('finger-print-device-infos.edit', $id)->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        try {
            $this->authorize('fingerprint-device-delete');

            DB::transaction(function () use ($id) {
                FingerPrintDeviceInfo::find($id)->delete();
            });
            return redirect()->route('finger-print-device-infos.index')->with('message', 'Device Info deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->route('finger-print-device-infos.index')->withInput()->withErrors($e->getMessage());
        }
    }

    public function deviceConnectionCheck($id)
    {

        try {
            $this->authorize('fingerprint-device-connect');

            $device = FingerPrintDeviceInfo::find($id);
            $zk = new ZKTeco($device->device_ip);
            $connected =  $zk->connect();
            if ($connected == true) {
                return redirect()->route('finger-print-device-infos.index')->with('message', 'Device Connected Successfully');
            } else {
                return redirect()->route('finger-print-device-infos.index')->withErrors('message', 'Device Connected Successfully');
            }
        } catch (QueryException $e) {
            return redirect()->route('finger-print-device-infos.index')->withInput()->withErrors($e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->route('finger-print-device-infos.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
