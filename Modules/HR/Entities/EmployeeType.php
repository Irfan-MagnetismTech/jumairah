<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{

    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'employee_type_id', 'id');
    }
    public function salarySettings()
    {
        return $this->hasMany(SalarySetting::class, 'employee_type_id', 'id');
    }
}
