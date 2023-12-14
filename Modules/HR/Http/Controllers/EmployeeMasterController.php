<?php

namespace Modules\HR\Http\Controllers;

use PDF;
use DateTime;
use App\Employee;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Http\Request;
use Modules\HR\Entities\Bank;
use Modules\HR\Entities\Line;
use Modules\HR\Entities\Unit;
use Modules\HR\Entities\Floor;
use Modules\HR\Entities\Grade;
use Modules\HR\Entities\Shift;
use Modules\HR\Entities\Gender;
use Modules\HR\Entities\PayMode;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\District;
use Modules\HR\Entities\Division;
use Modules\HR\Entities\Religion;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Department;
use Modules\HR\Entities\SubSection;
use Modules\HR\Entities\Designation;
use Modules\HR\Entities\JobLocation;
use Modules\HR\Entities\EmployeeType;
use Modules\HR\Entities\AttendanceRow;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Modules\HR\Entities\AppointmentLetter;
use Illuminate\Contracts\Support\Renderable;
use Modules\HR\Entities\FingerPrintDeviceInfo;
use Modules\SoftwareSettings\Entities\CompanyInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeMasterController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('employee-show');
        $employees = Employee::with('department', 'designation', 'section')->latest()->get();
        return view('hr::employee-master.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('employee-create');
        $formType = 'create';
        $department = Department::orderBy('name')->pluck('name', 'id');
        $section = Section::orderBy('name')->pluck('name', 'id');
        $sub_section = SubSection::orderBy('name')->pluck('name', 'id');
        $designation = Designation::orderBy('name')->pluck('name', 'id');

        $floor = Floor::orderBy('name')->pluck('name', 'id');
        $line = Line::orderBy('name')->pluck('name', 'id');
        $employeeType = EmployeeType::orderBy('name')->pluck('name', 'id');
        $shift = Shift::orderBy('name')->pluck('name', 'id');
        $jobLocations = JobLocation::orderBy('name')->pluck('name', 'id');
        $gender = Gender::orderBy('name')->pluck('name', 'id');
        $religion = Religion::orderBy('name')->pluck('name', 'id');
        $grade = Grade::orderBy('name')->pluck('name', 'id');
        $division = Division::orderBy('name')->pluck('name', 'id');
        $paymode = PayMode::orderBy('name')->pluck('name', 'id');
        $bank = Bank::orderBy('name')->pluck('name', 'id');
        $fingerprintDevices = FingerPrintDeviceInfo::orderBy('device_name')->pluck('device_name', 'id');

        return view('hr::employee-master.create', compact(
            'formType',
            'department',
            'section',
            'sub_section',
            'designation',
            'floor',
            'line',
            'employeeType',
            'shift',
            'jobLocations',
            'gender',
            'religion',
            'grade',
            'division',
            'paymode',
            'bank',
            'fingerprintDevices'
        ));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->authorize('employee-create');
        $request->validate([
            'emp_img' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'max:2000'],
            'finger_id' => ['unique:employees,finger_id', 'nullable'],
        ]);

        $employee = $request->except(
            '_token',
            'employee_detail',
            'employee_address',
            'employee_bank_info',
            'employee_family_info',
            'employee_nominee_info',
            'employee_education',
            'employee_experience',
            'emp_img',
            'emp_code',
            'emp_id'
        );

        $request->is_active == 1 ? $employee['is_active'] = 1 : $employee['is_active'] = 0;

        if ($request->emp_img) {
            $employee['emp_img_url'] = uploadImage($request->emp_img, 'emp_img');
        }

        // dd($employee);
        $employee_detail = $request->employee_detail;
        $employee_address = $request->employee_address;
        $employee_bank_info = $request->employee_bank_info;
        $employee_family_info = $request->employee_family_info;
        $employee_nominee_info = $request->employee_nominee_info;
        $employee_educations = $request->employee_education;
        $employee_experience = $request->employee_experience;

        $emp_code_initial = Employee::orderBy('id', 'desc')->first()->id ?? 0 . '-' . rand(1000, 9999);;
        $lastInsertedEmployeeId = DB::table('employees')->orderBy('id', 'desc')->value('id');

        $lastInsertedEmployeeId++;
        if ($request->department_id == 8) { // If department is head office, then code will MH-00000
            $employee['emp_code'] = "MH" . '-' . $lastInsertedEmployeeId;
        } else { // else code will be prefixed by company wise
            $employee['emp_code'] = $emp_code_initial . '-' . $lastInsertedEmployeeId;
        }

        try {

            DB::transaction(function () use (
                $employee,
                $employee_detail,
                $employee_address,
                $employee_bank_info,
                $employee_family_info,
                $employee_nominee_info,
                $employee_educations,
                $employee_experience
            ) {
                $employee = Employee::create($employee);
                $employee->employee_detail()->create($employee_detail);
                $employee->employee_address()->createMany($employee_address);
                $employee->employee_bank_info()->create($employee_bank_info);
                $employee->employee_family_info()->create($employee_family_info);
                $employee->employee_nominee_info()->createMany($employee_nominee_info);
                $employee->employee_education()->createMany($employee_educations ?? []);
                if (!empty($employee_experience)) {
                    $employee->employee_experience()->createMany($employee_experience ?? []);
                }
            });

            return redirect()->route('employee-masters.index')->with('message', 'Employee created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        $this->authorize('employee-create');

        if ($request->ajax()) {

            $employee = Employee::findOrFail($id)->load(
                'employee_address',
                'employee_bank_info',
                'employee_detail',
                'employee_education',
                'employee_experience',
                'employee_family_info',
                'employee_nominee_info',
            );

            return response()->json(['employee' => $employee]);
        } else {
            return view('hr::show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('employee-edit');
        $formType = 'edit';

        $employee = Employee::findOrFail($id)->load(
            'employee_address',
            'employee_bank_info',
            'employee_detail',
            'employee_education',
            'employee_experience',
            'employee_family_info',
            'employee_nominee_info',
        );

        $department = Department::orderBy('name')->pluck('name', 'id');
        $section = Section::orderBy('name')->pluck('name', 'id');
        $sub_section = SubSection::orderBy('name')->pluck('name', 'id');
        $designation = Designation::orderBy('name')->pluck('name', 'id');
        // $unit = Unit::orderBy('name')->pluck('name', 'id');
        $floor = Floor::orderBy('name')->pluck('name', 'id');
        $line = Line::orderBy('name')->pluck('name', 'id');
        $employeeType = EmployeeType::orderBy('name')->pluck('name', 'id');
        $shift = Shift::orderBy('name')->pluck('name', 'id');
        $jobLocations = JobLocation::orderBy('name')->pluck('name', 'id');
        $gender = Gender::orderBy('name')->pluck('name', 'id');
        $religion = Religion::orderBy('name')->pluck('name', 'id');
        $grade = Grade::orderBy('name')->pluck('name', 'id');
        $division = Division::orderBy('name')->pluck('name', 'id');
        $district = District::orderBy('name')->pluck('name', 'id');
        $paymode = PayMode::orderBy('name')->pluck('name', 'id');
        $bank = Bank::orderBy('name')->pluck('name', 'id');
        $fingerprintDevices = FingerPrintDeviceInfo::orderBy('device_name')->pluck('device_name', 'id');


        return view('hr::employee-master.create', compact(
            'formType',
            'department',
            'section',
            'sub_section',
            'designation',
            'floor',
            'line',
            'employeeType',
            'shift',
            'gender',
            'religion',
            'grade',
            'division',
            'district',
            'paymode',
            'bank',
            'employee',
            'jobLocations',
            'fingerprintDevices'
        ));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->authorize('employee-edit');

        $employee_info = Employee::findOrFail($id);

        $request->validate([
            'emp_img' => ['nullable', 'file', 'mimes:png,jpg,jpeg', 'max:2000'],
            'finger_id' => ['unique:employees,finger_id,' . $id, 'nullable'],
        ]);

        $employee = $request->except(
            '_token',
            'employee_detail',
            'employee_address',
            'employee_bank_info',
            'employee_family_info',
            'employee_nominee_info',
            'employee_education',
            'employee_experience',
            'emp_img',
            'emp_code',
            'emp_id'

        );

        $request->is_active == 1 ? $employee['is_active'] = 1 : $employee['is_active'] = 0;

        if ($request->emp_img) {
            $employee['emp_img_url'] = uploadImage($request->emp_img, 'emp_img', $employee_info->emp_img_url);
        }

        $employee_detail = $request->employee_detail;
        $employee_address = $request->employee_address;
        $employee_bank_info = $request->employee_bank_info;
        $employee_family_info = $request->employee_family_info;
        $employee_nominee_info = $request->employee_nominee_info;
        $employee_educations = $request->employee_education;
        $employee_experience = $request->employee_experience;
        try {

            DB::transaction(function () use (
                $employee,
                $employee_info,
                $employee_detail,
                $employee_address,
                $employee_bank_info,
                $employee_family_info,
                $employee_nominee_info,
                $employee_educations,
                $employee_experience
            ) {
                $employee_info->update($employee);

                $employee_info->employee_detail()->delete();
                $employee_info->employee_detail()->create($employee_detail);

                $employee_info->employee_address()->delete();
                $employee_info->employee_address()->createMany($employee_address);

                $employee_info->employee_bank_info()->delete();
                $employee_info->employee_bank_info()->create($employee_bank_info);

                $employee_info->employee_family_info()->delete();
                $employee_info->employee_family_info()->create($employee_family_info);

                $employee_info->employee_nominee_info()->delete();
                $employee_info->employee_nominee_info()->createMany($employee_nominee_info);


                $employee_info->employee_education()->delete();
                $employee_info->employee_education()->createMany($employee_educations ?? []);

                $employee_info->employee_experience()->delete();
                $employee_info->employee_experience()->createMany($employee_experience ?? []);
            });

            return redirect()->route('employee-masters.index')->with('message', 'Employee Updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
            $this->authorize('employee-delete');
            $employee_info = Employee::where('com_id', auth()->user()->com_id)->findOrFail($id);
            // dd($employee_info);
            $employee_info->employee_detail()->delete();
            $employee_info->employee_address()->delete();
            $employee_info->employee_bank_info()->delete();
            $employee_info->employee_family_info()->delete();
            $employee_info->employee_nominee_info()->delete();
            $employee_info->employee_education()->delete();
            $employee_info->employee_experience()->delete();
            $employee_info->delete();

            return redirect()->route('employee-masters.index')->with('message', 'Employee Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function fingerPrintData()
    {
        try {
            $zk = new ZKTeco('192.168.100.2');

            $zk->connect();
            $zk->enableDevice();


            // $user = $zk->setUser(887, "887", "demo", "123");

            $getusers = $zk->getUser();

            dd($getusers);


            $attData = $zk->getAttendance();

            $attendanceRowData = [];

            foreach ($attData as $key => $data) {
                $employee = Employee::with('shift')->where('id', $data['id'])->first();

                $timestamp = $data['timestamp']; // Replace this with your timestamp
                list($date, $time) = explode(' ', $timestamp);


                // Convert the timestamp to a DateTime object
                $dateObject = new DateTime($date);
                $timeObject = new DateTime($time);

                if ($employee) {
                    $attendanceRowData[] = [
                        'emp_id' => $employee->id,
                        'shift_id' => $employee->shift->id,
                        'card_no' => $employee?->emp_code,
                        'finger_print_id' => $data['uid'],
                        'punch_date' => $dateObject->format('Y-m-d'),
                        'punch_time' => $timeObject->format('H:i:s'),

                    ];
                }
            }

            $insert = AttendanceRow::insert($attendanceRowData);

            if ($insert) {
                return view('hr::fingerprint-attendance.index', [
                    'fingerprint_attendances' => AttendanceRow::with('employee')->latest()->get()
                ]);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function appointmentLetters()
    {
        $this->authorize('employee-appointment-letter-show');
        $appointmentLetters = AppointmentLetter::with('employee', 'creator')->get();

        return view('hr::idcard-appointment-letter.appointment-letter-list', compact('appointmentLetters'));
    }

    public function appointmentLettersGenerate($appointment_letter_id)
    {
        $this->authorize('employee-appointment-letter-create');

        $appointmentLetter = AppointmentLetter::find($appointment_letter_id);

        $employee = Employee::find($appointmentLetter->employee_id);
        $employees = [$employee];
        $print_date_time = $appointmentLetter->created_id;
        $job_location = $appointmentLetter->job_location;
        $terms_and_conditions = $appointmentLetter->terms_and_conditions;
        $pdf = PDF::loadView(
            'hr::idcard-appointment-letter.print-appointmentletter',
            compact('employees', 'print_date_time', 'terms_and_conditions', 'job_location'),
            [],
            [
                'watermark'     => auth()->user()->company->company_name,
                'show_watermark'   => true,
                'title' => 'Employee Appointment Letter',
                'format' => 'A4',
                'orientation' => 'P',
            ]
        );

        return $pdf->stream('appointment_letter.pdf');
    }

    public function checkFingerIdUniqueness($device_id, $finger_id, $ignore_id = null)
    {
        $this->authorize('employee-create');
        $found_employees = Employee::query();

        $found_employees->when($ignore_id, function ($query) use ($ignore_id) {
            return $query->whereNotIn('id', [$ignore_id]);
        });

        $found_employees = $found_employees->where('fingerprint_device_id', $device_id)->where('finger_id', $finger_id)->get();

        if ($found_employees->isNotEmpty()) {
            $last_finger_id = DB::table('employees')->max('finger_id');
            return response()->json(['message' => "finger id already exists in selected device. Please choose another number after $last_finger_id"], 500);
        }
    }
}
