<?php

namespace Modules\HR\Http\Controllers;

use Exception;
use App\Department;
use Illuminate\Http\Request;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\EmployeeOt;
use Illuminate\Support\Facades\Auth;
// use Modules\HR\Entities\Department;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeOtController extends Controller
{
    use AuthorizesRequests;

    function index()
    {
        $departments = Department::pluck('name', 'id');
        $employees = Employee::pluck('emp_name', 'id');
        return view('hr::employee-ot.index', compact('departments', 'employees'));
    }


    function saveEmployeeOtRecords(Request $request)
    {

        try {
            $ot_records = collect($request->ot_records);
            $ot_records_employees = $ot_records->pluck('employee_id');

            EmployeeOt::where('date', $request->date)
                ->whereIn('employee_id', [...$ot_records_employees])
                ->delete();

            $ot_records = $ot_records->map(function ($ot_record) {
                $ot_record['created_at'] = now();
                $ot_record['updated_at'] = now();

                $ot_record['ot_hour'] = $this->convertToConsistentFormat($ot_record['ot_hour']);

                if ($this->isTimeLessThan8Hours($ot_record['ot_hour']) && $ot_record['ot_hour'] != false) {
                    return $ot_record;
                }
            });

            DB::table('employees_ot')->insert($ot_records->all());
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    function isTimeLessThan8Hours($time)
    {
        // Assuming $time is in the format HH:mm
        $referenceTime = "08:00";

        // Convert times to seconds
        $timeInSeconds = strtotime($time) - strtotime("00:00");
        $referenceTimeInSeconds = strtotime($referenceTime) - strtotime("00:00");

        // Compare the times
        return $timeInSeconds <= $referenceTimeInSeconds;
    }

    function convertToConsistentFormat($input)
    {
        // Define the pattern for various time formats (xx:x, xx:xx, x:x, x:xx)
        $pattern = '/^(\d{1,2}):(\d{1,2})$/';

        // Check if the input matches the pattern
        if (preg_match($pattern, $input, $matches)) {
            // Extract hours and minutes from the matched groups
            $hours = $matches[1];
            $minutes = $matches[2];

            // Ensure that hours and minutes are valid integers
            if (ctype_digit($hours) && ctype_digit($minutes)) {
                // Pad hours and minutes with leading zeros
                $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

                // Return the time in xx:xx format
                return $hours . ':' . $minutes;
            }
        }

        // Return false if the input doesn't match any recognized format or contains invalid characters
        return false;
    }





    /**
     * Retrieves overtime (OT) records for employees based on conditions
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     *
     * @return \Illuminate\Support\Collection The collection of OT records for employees.
     */
    function getEmployeeOtRecords(Request $request)
    {
        try {
            $request->validate([
                'department_id' => 'required',
                'date' => 'required|date',
            ]);

            $otRecords = DB::table('employees')
                ->where('employees.department_id', $request->department_id)
                ->when($request->employee_id, function ($query) use ($request) {
                    return $query->whereIn('employees.id', [...$request->employee_id]);
                })
                ->leftJoin('employees_ot', function ($join) use ($request) {
                    $join->on('employees.id', '=', 'employees_ot.employee_id')

                        ->where('employees_ot.date', '=', $request->date)
                        ->orWhere('employees_ot.date', null);
                })
                ->select(
                    'employees.id as employee_id',
                    'employees.emp_code',
                    'employees.emp_name',
                    // DB::raw("CONCAT(employees.emp_code, ' - ', employees.emp_name) AS emp_name"),
                    'employees_ot.ot_hour'
                )
                ->get();

            return $otRecords;
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
