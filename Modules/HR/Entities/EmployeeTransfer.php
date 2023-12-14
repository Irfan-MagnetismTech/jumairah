<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeTransfer extends Model
{
   
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id' , 'id');
    }

    public function old_designation()
    {
        return $this->belongsTo(Designation::class, 'old_designation_id' , 'id');
    }

    public function new_designation()
    {
        return $this->belongsTo(Designation::class, 'new_designation_id' , 'id');
    }

    public function old_department()
    {
        return $this->belongsTo(Department::class, 'old_department_id' , 'id');
    }

    public function new_department()
    {
        return $this->belongsTo(Department::class, 'new_department_id' , 'id');
    }

    public function old_section()
    {
        return $this->belongsTo(Section::class, 'old_section_id' , 'id');
    }

    public function new_section()
    {
        return $this->belongsTo(Section::class, 'new_section_id' , 'id');
    }

    public function old_emp_type()
    {
        return $this->belongsTo(EmployeeType::class, 'old_emp_type_id' , 'id');
    }

    public function new_emp_type()
    {
        return $this->belongsTo(EmployeeType::class, 'new_emp_type_id' , 'id');
    }
}
