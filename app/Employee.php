<?php

namespace App;

use Carbon\Carbon;
use App\Department;
use App\Designation;
use Modules\HR\Entities\Line;
use Modules\HR\Entities\Unit;
use Modules\HR\Entities\Floor;
use Modules\HR\Entities\Shift;
use Modules\HR\Entities\Gender;
use Modules\HR\Entities\Section;
use Modules\HR\Entities\Religion;
use Modules\HR\Entities\EmployeeOt;
use Modules\HR\Entities\SubSection;
use Modules\HR\Entities\JobLocation;
use Modules\HR\Entities\EmployeeType;
use Modules\HR\Entities\LeaveBalance;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\EmployeeDetail;
use Modules\HR\Entities\EmployeeAddress;
use Modules\HR\Entities\EmployeeRelease;
use Modules\HR\Entities\ProcessedSalary;
use Modules\HR\Entities\EmployeeBankInfo;
use Modules\HR\Entities\EmployeeEducation;
use Modules\HR\Entities\EmployeeExperience;
use Modules\HR\Entities\EmployeeFamilyInfo;
use Modules\HR\Entities\EmployeeNomineeInfo;
use Modules\HR\Entities\ProcessedBonusDetail;

class Employee extends Model
{
    protected $guarded = ['division_id', 'district_id'];
    public function setDobAttribute($input)
    {
        !empty($input) ? $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDobAttribute($input)
    {
        $dob = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $dob;
    }
    public function getFullNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->withDefault();
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault();
    }
    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
    public function preThana()
    {
        return $this->belongsTo(Thana::class, 'pre_thana_id')->withDefault();
    }
    public function perThana()
    {
        return $this->belongsTo(Thana::class, 'per_thana_id');
    }

  
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }



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


    public function employee_nominee_info()
    {
        return $this->hasMany(EmployeeNomineeInfo::class, 'employee_id', 'id');
    }



    public function jobLocation()
    {
        return $this->belongsTo(JobLocation::class, 'job_location_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function sub_section()
    {
        return $this->belongsTo(SubSection::class, 'sub_section_id', 'id');
    }


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function line()
    {
        return $this->belongsTo(Line::class, 'line_id', 'id');
    }

    public function employee_type()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
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
