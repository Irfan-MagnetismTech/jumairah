<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
   
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'shift_id', 'id');
    }
    public function employeeshiftentry()
    {
        return $this->hasMany(EmployeeShiftEntry::class, 'shift_id', 'id');
    }
}
