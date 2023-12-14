<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class SalarySetting extends Model
{
    
    protected $guarded = [];

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }
}
