<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\ProcessedAttendance;
use Modules\HR\Entities\FixAttendance;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceReportController extends Controller
{
    use AuthorizesRequests;

    public function lateReportIndex(){
        $this->authorize('show-fingerprint-attendance');
        return view('hr::attendance-report.late');
    }

    public function getLateReportData(Request $request){
        $this->authorize('show-fingerprint-attendance');
        $from_date= $request->from_date;
        $to_date= $request->to_date;
        $lateEmployees= ProcessedAttendance::where('processed_attendances.com_id', auth()->user()->com_id)->
        select('employees.*','shifts.name as shift_name', DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(processed_attendances.late))) as total_late'))
        ->leftJoin('employees', 'employees.id', '=', 'processed_attendances.emp_id')
        ->leftJoin('shifts', 'employees.shift_id', '=', 'shifts.id')
        ->when($from_date && $to_date, function ($query) use($from_date, $to_date) {
            return $query->whereBetween('punch_date', [$from_date, $to_date]);
        })
        ->groupBy('processed_attendances.emp_id')->get();

        return $lateEmployees;
    }



}
