<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeOt extends Model
{
    
    protected $guarded = [];
    protected $table = 'employees_ot';

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
