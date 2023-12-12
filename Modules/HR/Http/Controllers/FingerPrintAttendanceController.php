<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\AttendanceRow;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\FingerPrintDeviceInfo;
use Mpdf\Tag\Tr;
use Rats\Zkteco\Lib\ZKTeco;

class FingerPrintAttendanceController extends Controller
{

    use AuthorizesRequests;
    /*
    * Show the finger print attendance management page
    */
    public function index()
    {
        $this->authorize('show-fingerprint-attendance');
        $devices = DB::table('finger_print_device_infos')
            ->select(DB::raw('CONCAT(device_ip, " - ", device_name, " - ",device_location) as device'), 'id')->pluck('device', 'id')
            ->toArray();
        // $devices = FingerPrintDeviceInfo::latest()->pluck('device_name', 'id');
        return view('hr::finger-print-attendance.index', compact('devices'));
    }

    /*
    * Process & Fetch device and date wise attendance log
    **/
    public function getDeviceAndDateWiseAttendanceLog(Request $request)
    {
        $this->authorize('process-fingerprint-attendance');

        $request->validate([
            'device_id' => 'required',
            // 'date_from' => 'required|date',
            // 'date_to' => 'required|date',
        ]);



        $device_ip = FingerPrintDeviceInfo::find($request->device_id)->device_ip;

        try {

            if ($request->process == true) {
                $zk = new ZKTeco($device_ip);

                $zk->connect();
                $zk->enableDevice();
                $attData = $zk->getAttendance(); // now fetching all. in future fetch by date_from & date_to wise

                //return (collect($attData)->pluck('id'));
                $employees = Employee::where('com_id', auth()->user()->com_id)->where('fingerprint_device_id', $request->device_id)->whereIn('finger_id', collect($attData)->pluck('id'))->get()->keyBy('finger_id');
                //dd($attData);
                foreach ($attData as $key => $data) {

                    $employee = isset($employees[$data['id']]) ? $employees[$data['id']] : [];

                    if (isset($employees[$data['id']])) {
                        $timestamp = $data['timestamp'];
                        list($date, $time) = explode(' ', $timestamp);

                        $dateObject = new DateTime($date);
                        $timeObject = new DateTime($time);

                        if ($employee && AttendanceRow::where('finger_print_id', $data['uid'])->get()->count() == 0) {
                            $attdRow =  new AttendanceRow();
                            $attdRow->emp_id = $employee->id;
                            $attdRow->device_id = $request->device_id;
                            $attdRow->shift_id = $employee?->shift?->id;
                            $attdRow->card_no = $employee?->emp_code;
                            $attdRow->finger_print_id = $data['uid'];
                            $attdRow->punch_date = $dateObject->format('Y-m-d');
                            $attdRow->punch_time =  $timeObject->format('H:i:s');
                            $attdRow->save();
                        }
                    }
                }
            }

            if ($request->date_form && $request->date_to) {

                // in future when we will get date_from and date_to from frontend, remove this if else block and keep only the code of this block

                $startDate = Carbon::createFromFormat('m/d/Y', $request->date_form)->format('Y-m-d');
                $endDate = Carbon::createFromFormat('m/d/Y', $request->date_to)->format('Y-m-d');
                $attendance_logs = AttendanceRow::where('com_id', auth()->user()->com_id)->whereBetween('punch_date', [$startDate, $endDate])->with('employee', 'device')->get();
                return response()->json($attendance_logs);
            } else {
                $today = Carbon::now();
                $formattedDate = $today->format('Y-m-d');
                return   AttendanceRow::where('com_id', auth()->user()->com_id)->with('employee', 'device')
                    // ->where('punch_date',$formattedDate)
                    ->latest()->paginate(15);
            }
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /*
    * Clear All attendance log of a device
    **/
    public function clearDeviceWiseAttendanceLog(Request $request)
    {
        $this->authorize('clear-fingerprint-attendance');

        $request->validate([
            'device_id' => 'required',
        ]);

        $device_ip = FingerPrintDeviceInfo::find($request->device_id)->device_ip;

        try {
            $zk = new ZKTeco($device_ip);
            $connected =  $zk->connect();
            $enabled = $zk->enableDevice();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($zk->clearAttendance());
    }


    /*
    * Fetch Device Wise Users
    */
    public function getDeviceWiseUsers(Request $request)
    {
        $this->authorize('show-device-users');

        $request->validate([
            'device_id' => 'required',
        ]);

        $device_ip = FingerPrintDeviceInfo::find($request->device_id)->device_ip;

        try {
            $zk = new ZKTeco($device_ip);
            $connected =  $zk->connect();
            $enabled = $zk->enableDevice();
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($zk->getUser());
    }
}
