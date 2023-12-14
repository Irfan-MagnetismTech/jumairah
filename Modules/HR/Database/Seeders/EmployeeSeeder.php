<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\HR\Entities\Department;
use Modules\HR\Entities\Designation;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\FingerPrintDeviceInfo;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate tables before seeding fresh data
        DB::table('employees')->truncate();
        DB::table('employee_addresses')->truncate();
        DB::table('employee_details')->truncate();
        DB::table('employee_bank_infos')->truncate();
        DB::table('employee_education')->truncate();
        DB::table('employee_experiences')->truncate();
        DB::table('employee_family_infos')->truncate();
        DB::table('employee_nominee_infos')->truncate();

        $HeadOfficeFingerPrintDeviceID = FingerPrintDeviceInfo::where('device_ip','163.47.87.238')->first()->id;

        $gil_com_id = "feb4b55f-df58-4aff-8ec2-5cbc12c8e029";
        $hm_com_id  = "6fa50914-e296-49c5-b43b-3b73650ee807";

        $csvFile = 'Modules/HR/Database/Seeders/Data/final-emp-list.csv';

        $headerLine = true;
        $delimiter = ',';

        if (($handle = fopen($csvFile, 'r')) !== false) {

            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {

                // Com ID Determination
                if (strstr($data[0], "GIL")) {
                    $com_id = $gil_com_id;
                } else if (strstr($data[0], "HMS")) {
                    $com_id = $hm_com_id;
                }

                // Create Department If not found/ if found use it
                $department = DB::table('departments')->where('name', trim($data[3]))->where('com_id', $com_id)->first();
                if (empty($department)) {
                    $departmentId = DB::table('departments')->insertGetId(['name' => trim($data[3]), 'com_id' => $com_id]);
                } else {
                    $departmentId = $department->id;
                }

                // Create Designation If not found/ if found use it
                $designation = DB::table('designations')->where('name', trim($data[2]))->where('com_id', $com_id)->first();
                if (empty($designation)) {
                    $designationId = DB::table('designations')->insertGetId(['name' => trim($data[2]), 'com_id' => $com_id]);
                } else {
                    $designationId = $designation->id;
                }

                // Create Job Locations If not found/ if found use it
                $jobLocation = DB::table('job_locations')->where('name', trim($data[4]))->where('com_id', $com_id)->first();
                if (empty($jobLocation)) {
                    $jobLocationId = DB::table('job_locations')->insertGetId(['name' => trim($data[4]), 'com_id' => $com_id]);
                } else {
                    $jobLocationId = $jobLocation->id;
                }


                $employeeID =
                    DB::table('employees')
                    ->insertGetId([
                        'emp_name' => trim($data[1]),
                        'department_id' => $departmentId,
                        'designation_id' => $designationId,
                        'job_location_id' => $jobLocationId,
                        'join_date' =>  $data[5] ? date("Y-m-d", strtotime($data[5])): null,
                            //date_format(date_create_from_format('m/d/y', $data[5]), 'Y-m-d') : null,
                        'com_id' => $com_id,
                        'emp_code' => $data[0],

                        // finger id and device info for head office only
                        'finger_id' => !empty($data[6]) ? $data[6]: 0,
                        'fingerprint_device_id' => $data[6]? $HeadOfficeFingerPrintDeviceID :  0,
                    ]);

                // Employee Bank Info Data
                // Now all pay_mode_id is 1 that means cash and so no bank data required
                // DB::table('employee_bank_infos')
                //     ->insert([
                //         'employee_id' => $employeeID,
                //         'pay_mode_id' => $data[6] ? 2 : 1,
                //         'account_number' => $data[6] ?? null,
                //     ]);

                // Employee Salary
                // DB::table('employee_salaries')
                //     ->insert([
                //         'employee_id' => $employeeID,
                //         'gross_salary' => $data[3] ? trim($data[3]) : null,
                //     ]);


            }

            fclose($handle);
        }
    }
}
