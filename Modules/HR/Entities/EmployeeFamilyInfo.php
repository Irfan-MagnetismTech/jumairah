<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeFamilyInfo extends Model
{
    
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id' , 'id');
    }
}
