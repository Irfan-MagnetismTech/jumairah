<?php

namespace Modules\HR\Entities;

use App\Department;
use App\Designation;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = [];

    public function employee_address()
    {
        return $this->hasMany(EmployeeAddress::class, 'employee_id', 'id');
    }

    public function employee_bank_info()
    {
        return $this->hasOne(EmployeeBankInfo::class, 'employee_id', 'id');
    }

    public function employee_detail()
    {
        return $this->hasOne(EmployeeDetail::class, 'employee_id', 'id');
    }

    public function employee_education()
    {
        return $this->hasMany(EmployeeEducation::class, 'employee_id', 'id');
    }

    public function employee_experience()
    {
        return $this->hasMany(EmployeeExperience::class, 'employee_id', 'id');
    }

    public function employee_family_info()
    {
        return $this->hasOne(EmployeeFamilyInfo::class, 'employee_id', 'id');
    }
    public function employee_salary()
    {
        return $this->hasOne(EmployeeSalary::class, 'employee_id', 'id');
    }

    public function employee_nominee_info()
    {
        return $this->hasMany(EmployeeNomineeInfo::class, 'employee_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id' , 'id');
    }

    public function jobLocation()
    {
        return $this->belongsTo(JobLocation::class, 'job_location_id' , 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id' , 'id');
    }

    public function sub_section()
    {
        return $this->belongsTo(SubSection::class, 'sub_section_id' , 'id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id' , 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id' , 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id' , 'id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id' , 'id');
    }

    public function employee_type()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id' , 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id' , 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id' , 'id');
    }

    public function leave_balance_emp()
    {
        return $this->hasMany(LeaveBalance::class, 'emp_id', 'id');
    }


    public function employeeRelease()
    {
        return $this->hasOne(EmployeeRelease::class, 'employee_id', 'id');
    }

    public function processed_salary()
    {
        return $this->hasOne(ProcessedSalary::class, 'emp_id', 'id');
    }

    public function processed_bonous()
    {
        return $this->hasMany(ProcessedBonusDetail::class, 'employee_id', 'id');
    }

    public function ot_records()
    {
        return $this->hasMany(EmployeeOt::class, 'employee_id');
    }


}
