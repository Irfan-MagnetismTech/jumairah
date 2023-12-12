<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeShiftEntry extends Model
{
   
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id' , 'id');
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id' , 'id');
    }
}
