<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\AttendanceRow;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\FingerPrintDeviceInfo;
use Rats\Zkteco\Lib\ZKTeco;

class AttendanceLogController extends Controller
{
    public function attendanceLogList(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');
        //dd($today_date);
        $attendance_logs = AttendanceRow::where('com_id', auth()->user()->com_id)->whereDate('punch_date', $today_date)->with('employee','device')->get();
        return view("hr::attendance-log.index", compact('attendance_logs'));
    }

    public function attendanceLogProcess()
    {
        try {

            $devices = FingerPrintDeviceInfo::latest()->get();

            foreach ($devices as $device) {
                $zk = new ZKTeco($device->device_ip);

                $zk->connect();
                $zk->enableDevice();
                $attData = $zk->getAttendance();

                foreach ($attData as $key => $data) {
                    $employee = Employee::with('shift')->where('id', $data['id'])->first();

                    $timestamp = $data['timestamp'];
                    list($date, $time) = explode(' ', $timestamp);

                    $dateObject = new DateTime($date);
                    $timeObject = new DateTime($time);
                    if ($employee && AttendanceRow::where('finger_print_id', $data['uid'])->get()->count() == 0) {

                        $attdRow =  new AttendanceRow();
                        $attdRow->emp_id = $employee->id;
                        $attdRow->device_id = $device->id;
                        $attdRow->shift_id = $employee->shift->id;
                        $attdRow->card_no = $employee?->emp_code;
                        $attdRow->finger_print_id = $data['uid'];
                        $attdRow->punch_date = $dateObject->format('Y-m-d');
                        $attdRow->punch_time =  $timeObject->format('H:i:s');
                        $attdRow->save();
                    }
                }
            }


            return redirect()->route('attendance-log.list')->with('message', 'attendance log processed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
