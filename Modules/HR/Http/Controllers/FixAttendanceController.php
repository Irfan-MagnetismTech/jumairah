<?php

namespace Modules\HR\Http\Controllers;

use Carbon\Carbon;
use App\Department;
use App\Designation;
use Illuminate\Http\Request;
use Modules\HR\Entities\Shift;
use Modules\HR\Entities\Holiday;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\Employee;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\HR\Entities\FixAttendance;
use Illuminate\Contracts\Support\Renderable;
use Modules\HR\Entities\ProcessedAttendance;
use Modules\SoftwareSettings\Entities\CompanyInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FixAttendanceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('fix-attendance-show');
        $fix_attendances = FixAttendance::with('employee')->latest()->get();

        return view('hr::fix-attendance.index', compact('fix_attendances'));
    }
    public function index_processed()
    {
        $this->authorize('process-attendance');
        $processed_attendances = ProcessedAttendance::with('employee')->latest()->orderBy('punch_date', 'desc')->get();
        $departments = Department::orderBy('name')->pluck('name', 'id');

        return view('hr::fix-attendance.index_processed', compact('processed_attendances', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('fix-attendance-create');
        $formType = 'create';
        // $com_id = Auth::user()->com_id;
        // $company_info= CompanyInfo::with('companysetting')->where('com_id',$com_id)->latest()->first();
        $holidays = Holiday::whereDate('date', date("Y-m-d"))->where('type', 'h')->latest()->first();

        $departments = Department::orderBy('name')->pluck('name', 'id');
        $designations = Designation::orderBy('name')->pluck('name', 'id');
        $sections = Section::where('status', 'Active')->pluck('name', 'id');
        $shifts = Shift::where('status', 'Active')->pluck('name', 'id');
        $employees = Employee::with('employee_salary')->where('is_active', 1)->pluck('emp_name', 'id');


        return view('hr::fix-attendance.create', compact('formType', 'employees', 'departments', 'designations', 'holidays', 'sections', 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $this->authorize('fix-attendance-create');
            DB::transaction(function () use ($request) {
                foreach ($request->emp_id as $key => $id) {

                    $getFixdata = FixAttendance::where('emp_id', $id)->whereDate('punch_date', $request->table_punch_date[$key])->latest()->first();

                    $employee = Employee::find($id);
                    if ($getFixdata == null) {
                        $fix_attendance = new FixAttendance();
                        $fix_attendance['emp_id'] = $id;
                        $fix_attendance['emp_card_id'] = $employee?->emp_code;
                        $fix_attendance['employee_type_id'] = $employee->employee_type_id;
                        $fix_attendance['department_id'] = $employee->department_id;
                        $fix_attendance['section_id'] = $employee->section_id;
                        $fix_attendance['sub_section_id'] = $employee->sub_section_id;
                        $fix_attendance['designation_id'] = $employee->designation_id;
                        $fix_attendance['shift_id'] = $employee->shift_id;
                        $fix_attendance['floor_id'] = $employee->floor_id;
                        $fix_attendance['line_id'] = $employee->line_id;
                        $fix_attendance['shift_id'] = $request->shift_id[$key];

                        $fix_attendance['late'] = $request->table_late[$key];
                        $fix_attendance['punch_date'] = $request->table_punch_date[$key];
                        $fix_attendance['time_in'] = $request->table_time_in[$key];
                        $fix_attendance['time_out'] = $request->table_time_out[$key];
                        $fix_attendance['ot_hour'] = $request->table_ot_hour[$key];
                        $fix_attendance['status'] = $request->table_status[$key];
                        $fix_attendance['remarks'] = $request->table_remarks[$key];
                        $fix_attendance->save();
                    } else {
                        $getFixdata->emp_card_id = $employee?->emp_code;
                        $getFixdata->late = $request->table_late[$key];
                        $getFixdata->punch_date = $request->table_punch_date[$key];
                        $getFixdata->time_in = $request->table_time_in[$key];
                        $getFixdata->time_out = $request->table_time_out[$key];
                        $getFixdata->ot_hour = $request->table_ot_hour[$key];
                        $getFixdata->status = $request->table_status[$key];
                        $getFixdata->remarks = $request->table_remarks[$key];
                        $getFixdata->save();
                    }
                }
            });

            $message = ['success' => 'Fix Attendance Created Successfully'];
            return redirect()->route('fix-attendances.index')->with($message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
            // return $message;
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
        //
    }


    public function singleInsertOrUpdate(Request $request)
    {
        // dd($request);
        try {

            $this->authorize('fix-attendance-create');

            DB::transaction(function () use ($request) {
                $getFixdata = FixAttendance::where('emp_id', $request->emp_id)->whereDate('punch_date', $request->punch_date)->latest()->first();

                $employee = Employee::find($request->emp_id);
                // dd($request);
                // $com_id = Auth::user()->com_id;
                if ($getFixdata == null) {
                    $fix_attendance = new FixAttendance();
                    $fix_attendance['emp_id'] = $request->emp_id;
                    $fix_attendance['emp_card_id'] = $employee?->emp_code;
                    $fix_attendance['employee_type_id'] = $employee->employee_type_id;
                    $fix_attendance['department_id'] = $employee->department_id;
                    $fix_attendance['section_id'] = $employee->section_id;
                    $fix_attendance['sub_section_id'] = $employee->sub_section_id;
                    $fix_attendance['designation_id'] = $employee->designation_id;
                    $fix_attendance['shift_id'] = $employee->shift_id;
                    $fix_attendance['floor_id'] = $employee->floor_id;
                    $fix_attendance['line_id'] = $employee->line_id;
                    $fix_attendance['shift_id'] = $request->shift_id;

                    $fix_attendance['late'] = $request->late;
                    $fix_attendance['punch_date'] = $request->punch_date;
                    $fix_attendance['time_in'] = $request->time_in;
                    $fix_attendance['time_out'] = $request->time_out;
                    // $fix_attendance['ot_hour']=$request->ot_hour;
                    $fix_attendance['status'] = $request->status;
                    // $fix_attendance['com_id'] = $com_id;
                    $fix_attendance['remarks'] = $request->remarks;
                    $fix_attendance->save();
                } else {
                    $getFixdata->emp_card_id = $employee?->emp_code;
                    $getFixdata->late = $request->late;
                    $getFixdata->punch_date = $request->punch_date;
                    $getFixdata->time_in = $request->time_in;
                    $getFixdata->time_out = $request->time_out;
                    // $getFixdata->ot_hour = $request->ot_hour;
                    $getFixdata->status = $request->status;
                    // $getFixdata->com_id = $com_id;
                    $getFixdata->action = 0;
                    $getFixdata->remarks = $request->remarks;
                    $getFixdata->save();
                }
            });
            $message = ['success' => 'Fix Attendance Created Successfully'];
            return $message;
        } catch (\Exception $e) {
            $message = ['error', 'Something went wrong'];
            return $message;
        }

        //
    }


    function calculateOvertimeHours($time_in, $time_out, $regularHoursPerDay, $overtimeThreshold)
    {
        $time_in_stamp = strtotime($time_in);
        $time_out_stamp = strtotime($time_out);

        $totalTimeWorked = $time_out_stamp - $time_in_stamp;

        $regularHoursInSeconds = $regularHoursPerDay * 3600;
        // $overtimeThresholdInSeconds = $overtimeThreshold * 3600;

        // Check if total time worked exceeds regular working hours
        if ($totalTimeWorked > $regularHoursInSeconds) {
            // Calculate overtime hours
            $overtimeHours = $totalTimeWorked - $regularHoursInSeconds;

            // Check if overtime exceeds the threshold
            // if ($overtimeHours > $overtimeThresholdInSeconds) {
            //     // Limit overtime to the threshold
            //     $overtimeHours = $overtimeThresholdInSeconds;
            // }
        } else {
            // No overtime
            $overtimeHours = 0;
        }
        // Convert overtime hours from seconds to hours
        $overtimeHours = $overtimeHours / 3600;

        return round($overtimeHours);
    }


    public function getDatewiseAttendance(Request $request)
    {
        $this->authorize('show-attendance');

        $today = Carbon::today();
        $proceed_attendances = [];
        $employees = [];

        $designation_id = $request->designation_id;
        $section_id = $request->section_id;
        $department_id = $request->department_id;
        $shift_id = $request->shift_id;
        $emp_id = '';

        if (is_numeric($request->employee_id)) {
            $emp_id = $request->employee_id;
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (!empty($from_date) && !empty($to_date)) {
            $today = '';
        }

        $proceed_attendances = ProcessedAttendance::with('employee', 'shift')
            ->leftJoin('employees', 'processed_attendances.emp_id', '=', 'employees.id')
            ->when($designation_id, function ($query, $designation_id) {
                return $query->where('employees.designation_id', $designation_id);
            })
            ->when($section_id, function ($query, $section_id) {
                return $query->where('employees.section_id', $section_id);
            })
            ->when($department_id, function ($query, $department_id) {
                return $query->where('employees.department_id', $department_id);
            })
            ->when($shift_id, function ($query, $shift_id) {
                return $query->where('employees.shift_id', $shift_id);
            })
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                return $query->whereBetween('punch_date', [$from_date, $to_date]);
            })
            ->when($today, function ($query2) use ($today) {
                return $query2->where('punch_date', $today);
            })
            ->when($emp_id, function ($query, $emp_id) {
                return $query->where('processed_attendances.emp_id', $emp_id);
            })
            ->orderBy('processed_attendances.id', 'desc')->get();


        if (count($proceed_attendances) == 0) {
            // for join with employee_shift_entries table
            $employees1 = Employee::with('shift')
                ->leftJoin('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
                ->leftJoin('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
                ->select(
                    'employees.*',
                    'shifts.id as shift_id',
                    'shifts.name as shift_name',
                    'shifts.shift_in',
                    'shifts.shift_out',
                    'shifts.shift_late',
                )
                ->when($emp_id, function ($query, $emp_id) {
                    return $query->where('employees.id', $emp_id);
                })
                ->whereDate('employee_shift_entries.date', $today)
                ->latest();
            // for join with shifts table
            $employees2 = Employee::leftJoin('shifts', 'employees.shift_id', '=', 'shifts.id')
                ->select(
                    'employees.*',
                    'shifts.id as shift_id',
                    'shifts.name as shift_name',
                    'shifts.shift_in',
                    'shifts.shift_out',
                    'shifts.shift_late',
                )
                ->when($emp_id, function ($query, $emp_id) {
                    return $query->where('employees.id', $emp_id);
                })
                ->latest();
            $employees = $employees1->union($employees2)->get();
        }

        return ['proceed_attendances' => $proceed_attendances, 'employees' => $employees];
    }




    // public function getDatewiseAttendance(Request $request)
    // {
    //     $today = Carbon::today();
    //     $proceed_attendances =[];
    //     $employees =[];

    //     // dd($request);
    //     $designation_id=$request->designation_id;
    //     $section_id=$request->section_id;
    //     $department_id=$request->department_id;
    //     $shift_id=$request->shift_id;
    //     $emp_id='';
    //     // dd(var_dump($request->employee_id));

    //     if(is_numeric($request->employee_id)){
    //         $emp_id=$request->employee_id;
    //     }
    //     $from_date= $request->from_date;
    //     $to_date= $request->to_date;
    //     if(empty($from_date) && empty($to_date)){
    //         $request['today']=$today;
    //     }else{
    //         $request['today']='';
    //     }

    //     // dd($emp_id);
    //     if((!empty($request->designation_id) || !empty($request->section_id) || !empty($request->department_id) || !empty($request->shift_id)))
    //     {

    //         //for join with employee_shift_entries table
    //         $proceed_attendances1 = ProcessedAttendance::leftJoin('employees', 'processed_attendances.emp_id', '=', 'employees.id')
    //         ->join('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
    //         ->join('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
    //         ->select(
    //             'processed_attendances.*',
    //             'shifts.name as shift_name',
    //             'shifts.shift_in',
    //             'shifts.shift_out',
    //             'shifts.shift_late',
    //         )
    //         ->whereDate('employee_shift_entries.date', $request->today)
    //         ->when($designation_id, function ($query,$designation_id) {
    //             return $query->where('employees.designation_id', $designation_id);
    //         })
    //         ->when($section_id, function ($query, $section_id) {
    //             return $query->where('employees.section_id', $section_id);
    //         })
    //         ->when($department_id, function ($query, $department_id) {
    //             return $query->where('employees.department_id', $department_id);
    //         })
    //         ->when($shift_id, function ($query, $shift_id) {
    //             return $query->where('employees.shift_id', $shift_id);
    //         })
    //         ->with('employee')
    //         ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
    //             return $query->whereBetween('punch_date', [$from_date, $to_date]);
    //         })
    //         ->when($request->today, function ($query2) {
    //             return $query2->where('punch_date', $request->today);
    //         })
    //         ->orderBy('processed_attendances.id', 'desc');

    //         //for join with shifts table
    //         $proceed_attendances2 = ProcessedAttendance::leftJoin('employees', 'processed_attendances.emp_id', '=', 'employees.id')
    //         ->join('shifts', 'employees.shift_id', '=', 'shifts.id')
    //         ->select(
    //             'processed_attendances.*',
    //             'shifts.name as shift_name',
    //             'shifts.shift_in',
    //             'shifts.shift_out',
    //             'shifts.shift_late',
    //         )
    //         ->when($designation_id, function ($query,$designation_id) {
    //             return $query->where('employees.designation_id', $designation_id);
    //         })
    //         ->when($section_id, function ($query, $section_id) {
    //             return $query->where('employees.section_id', $section_id);
    //         })
    //         ->when($department_id, function ($query, $department_id) {
    //             return $query->where('employees.department_id', $department_id);
    //         })
    //         ->when($shift_id, function ($query, $shift_id) {
    //             return $query->where('employees.shift_id', $shift_id);
    //         })
    //         ->with('employee')
    //         ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
    //             return $query->whereBetween('punch_date', [$from_date, $to_date]);
    //         })
    //         ->when($request->today, function ($query2) {
    //             return $query2->where('punch_date', $request->today);
    //         })
    //         ->orderBy('processed_attendances.id', 'desc');

    //         // union operation with this two objects
    //         $proceed_attendances = $proceed_attendances1->union($proceed_attendances2)->get();

    //         if(count($proceed_attendances)==0){
    //             // for join with employee_shift_entries
    //             $employees1=Employee::leftJoin('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
    //             ->leftJoin('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'employees.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->whereDate('employee_shift_entries.date', $request->today)
    //             ->when($designation_id, function ($query,$designation_id) {
    //                 return $query->where('employees.designation_id', $designation_id);
    //             })
    //             ->when($section_id, function ($query, $section_id) {
    //                 return $query->where('employees.section_id', $section_id);
    //             })
    //             ->when($department_id, function ($query, $department_id) {
    //                 return $query->where('employees.department_id', $department_id);
    //             })
    //             ->when($shift_id, function ($query, $shift_id) {
    //                 return $query->where('employees.shift_id', $shift_id);
    //             })
    //             ->orderBy('employees.id', 'desc');
    //             // for join with employee_shift_entries
    //             $employees2=Employee::leftJoin('shifts', 'employees.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'employees.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->when($designation_id, function ($query,$designation_id) {
    //                 return $query->where('employees.designation_id', $designation_id);
    //             })
    //             ->when($section_id, function ($query, $section_id) {
    //                 return $query->where('employees.section_id', $section_id);
    //             })
    //             ->when($department_id, function ($query, $department_id) {
    //                 return $query->where('employees.department_id', $department_id);
    //             })
    //             ->when($shift_id, function ($query, $shift_id) {
    //                 return $query->where('employees.shift_id', $shift_id);
    //             })
    //             ->orderBy('employees.id', 'desc');

    //             // union operation with this two objects
    //             $employees = $employees1->union($employees2)->get();
    //         }
    //     }
    //     else{
    //         if(($request->employee_id!=null)){

    //             // dd($emp_id);
    //             // for join with employee_shift_entries
    //             $proceed_attendances1 = ProcessedAttendance::with('employee')
    //             ->join('employees', 'processed_attendances.emp_id', '=', 'employees.id')
    //             ->join('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
    //             ->join('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'processed_attendances.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->whereDate('employee_shift_entries.date', $request->today)
    //             ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
    //                 return $query->whereBetween('punch_date', [$from_date, $to_date]);
    //             })
    //             ->when($request->today, function ($query2) {
    //                 return $query2->where('punch_date', $request->today);
    //             })
    //             ->when($emp_id, function ($query,$emp_id){
    //                     return $query->where('processed_attendances.emp_id',$emp_id);
    //             })
    //             ->latest();

    //             // dd($emp_id);
    //             // for join with shift table
    //             $proceed_attendances2 = ProcessedAttendance::with('employee')
    //             ->join('employees', 'processed_attendances.emp_id', '=', 'employees.id')
    //             ->join('shifts', 'employees.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'processed_attendances.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
    //                 return $query->whereBetween('punch_date', [$from_date, $to_date]);
    //             })
    //             ->when($request->today, function ($query2) {
    //                 return $query2->where('punch_date', $request->today);
    //             })
    //             ->when($emp_id, function ($query,$emp_id){
    //                 return $query->whereEmpId($emp_id);
    //             })
    //             ->latest();

    //             // union with this two data
    //             $proceed_attendances = $proceed_attendances1->union($proceed_attendances2)->get();
    //             // dd($proceed_attendances);

    //             // dd($proceed_attendances);
    //             if(count($proceed_attendances)==0){
    //                     // for join with employee_shift_entries table
    //                     $employees1=Employee::leftJoin('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
    //                     ->leftJoin('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
    //                     ->select(
    //                         'employees.*',
    //                         'shifts.name as shift_name',
    //                         'shifts.shift_in',
    //                         'shifts.shift_out',
    //                         'shifts.shift_late',
    //                     )
    //                     ->when($emp_id, function ($query,$emp_id){
    //                         return $query->where('employees.id',$emp_id);
    //                     })
    //                     ->whereDate('employee_shift_entries.date', $request->today)
    //                     ->latest();
    //                     // for join with shifts table
    //                     $employees2=Employee::leftJoin('shifts', 'employees.shift_id', '=', 'shifts.id')
    //                     ->select(
    //                         'employees.*',
    //                         'shifts.name as shift_name',
    //                         'shifts.shift_in',
    //                         'shifts.shift_out',
    //                         'shifts.shift_late',
    //                     )
    //                     ->when($emp_id, function ($query,$emp_id){
    //                         return $query->where('employees.id',$emp_id);
    //                     })
    //                     ->latest();

    //                     $employees = $employees1->union($employees2)->get();

    //             }
    //         }else{

    //             // for join with employee_shift_entries table
    //             $employees1=Employee::leftJoin('employee_shift_entries', 'employees.id', '=', 'employee_shift_entries.employee_id')
    //             ->leftJoin('shifts', 'employee_shift_entries.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'employees.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->whereDate('employee_shift_entries.date', $request->today)
    //             ->orderBy('employees.id', 'desc');

    //             // for join with shifts table
    //             $employees2=Employee::leftJoin('shifts', 'employees.shift_id', '=', 'shifts.id')
    //             ->select(
    //                 'employees.*',
    //                 'shifts.name as shift_name',
    //                 'shifts.shift_in',
    //                 'shifts.shift_out',
    //                 'shifts.shift_late',
    //             )
    //             ->orderBy('employees.id', 'desc');

    //             $employees = $employees1->union($employees2)->get();
    //         }

    //     }

    //     // dd($proceed_attendances);

    //     return ['proceed_attendances'=>$proceed_attendances,'employees'=>$employees];

    // }


    // public function processed(){
    //     // dd('ggdfg');
    //     $fix_attendances = FixAttendance::with('employee')->where('action',0)->latest()->get();

    //     try{
    //         DB::transaction(function() use($fix_attendances){
    //             $com_id= Auth::user()->com_id;
    //             foreach($fix_attendances as $key=>$data){
    //                 $processedAttendance=ProcessedAttendance::where('emp_id',$data->emp_id)
    //                 ->whereDate('punch_date', $data->punch_date)->latest()->first();
    //                 if($processedAttendance==null){
    //                     // dd($processedAttendance);
    //                     $processed_attendance= new ProcessedAttendance();
    //                     $processed_attendance['emp_id']=$data->emp_id;
    //                     $processed_attendance['punch_date']=$data->punch_date;
    //                     $processed_attendance['late']=$data->late;
    //                     $processed_attendance['time_in']=$data->time_in;
    //                     $processed_attendance['time_out']=$data->time_out;
    //                     $processed_attendance['ot_hour']=$data->ot_hour;
    //                     $processed_attendance['com_id']=$com_id;
    //                     $processed_attendance['status']=$data->status;
    //                     $processed_attendance->save();

    //                     FixAttendance::where('emp_id',$data->emp_id)->whereDate('punch_date', $data->punch_date)->update([
    //                         'action'=>1,
    //                     ]);

    //                 }else{
    //                     $processedAttendance->punch_date = $data->punch_date;
    //                     $processedAttendance->late = $data->late;
    //                     $processedAttendance->time_in = $data->time_in;
    //                     $processedAttendance->time_out = $data->time_out;
    //                     $processedAttendance->ot_hour = $data->ot_hour;
    //                     $processedAttendance->status = $data->status;
    //                     $processed_attendance['com_id']=$com_id;
    //                     $processedAttendance->save();
    //                     FixAttendance::where('emp_id',$data->emp_id)->whereDate('punch_date', $data->punch_date)->update([
    //                         'action'=>1,
    //                     ]);
    //                 }
    //             }

    //         });
    //         $message=['success'=>'Processed Attendance Created Successfully'];
    //         return redirect()->route('processed-attendances.index')->with($message);

    //     } catch(\Exception $e){
    //         return redirect()->back()->with('error','Something went wrong');
    //     }
    // }
}
