<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Grade;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{

    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }
}
