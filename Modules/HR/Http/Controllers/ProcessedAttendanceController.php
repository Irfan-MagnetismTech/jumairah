<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Modules\HR\Entities\Shift;
use Modules\HR\Entities\Holiday;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
// use Modules\HR\Entities\Department;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\Designation;
use Modules\HR\Entities\FixAttendance;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\HR\Entities\ProcessedAttendance;
use Modules\SoftwareSettings\Entities\CompanyInfo;

class ProcessedAttendanceController extends Controller
{
    use AuthorizesRequests;

    public function processedAttendances(Request $request)
    {
        $this->authorize('process-attendance');

        // $com_user_id = Auth::user()->com_id;

        $monthYear = explode("-", $request->month);
        $startDate = null;
        $endDate = null;
        if (count($monthYear) == 2) {
            $startDate = Carbon::create($monthYear[0], $monthYear[1], 1);
            $endDate = $startDate->copy()->endOfMonth();
        }

        try {
            if (count($monthYear) == 2) {
                foreach (Carbon::parse($startDate)->daysUntil($endDate) as $yeardate) {
                    $dateYear = date('Y-m-d', strtotime($yeardate));
                    DB::select("SET @DATE = ?, @Department= ? , @Overtime= ?", [$dateYear, $request->department_id, date("H:i:s", strtotime("00:00:00"))]);
                    DB::select("CALL attendance_processed(@DATE,@Department,@Overtime)");
                }
            } else {
                $date = date('Y-m-d', strtotime($request->date));
                DB::select("SET @DATE = ?, @Department= ? , @Overtime= ?", [$date, $request->department_id, date("H:i:s", strtotime("00:00:00"))]);
                DB::select("CALL attendance_processed(@DATE,@Department,@Overtime)");
            }
            return redirect()->back()->with('message', 'Attendance processed created successfully');
        } catch (Exception $e) {
            dd($e);

            return redirect()->back()->with('error', $e);
        }
        // try {
        //     if (count($monthYear) == 2) {
        //         foreach (Carbon::parse($startDate)->daysUntil($endDate) as $yeardate) {
        //             $dateYear = date('Y-m-d', strtotime($yeardate));
        //             DB::select("SET @DATE = ?, @Department= ? , @Overtime= ?,@Com_User= ?", [$dateYear, $request->department_id, date("H:i:s", strtotime("00:00:00") + $request->overtime * 3600), $com_user_id]);
        //             DB::select("CALL attendance_processed(@DATE,@Department,@Overtime,@Com_User)");
        //         }
        //     } else {
        //         $date = date('Y-m-d', strtotime($request->date));
        //         DB::select("SET @DATE = ?, @Department= ? , @Overtime= ? ,@Com_User= ?", [$date, $request->department_id, date("H:i:s", strtotime("00:00:00") + $request->overtime * 3600), $com_user_id]);
        //         DB::select("CALL attendance_processed(@DATE,@Department,@Overtime,@Com_User)");
        //     }
        //     return redirect()->back()->with('message', 'Attendance processed created successfully');
        // } catch (Exception $e) {

        //     return redirect()->back()->with('error', $e);
        // }
    }
}
