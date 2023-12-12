<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    
    protected $guarded = [];

    public function designations()
    {
        return $this->hasMany(Designation::class, 'grade_id', 'id');
    }
    public function employee_details()
    {
        return $this->hasMany(EmployeeDetail::class, 'grade_id', 'id');
    }
}
