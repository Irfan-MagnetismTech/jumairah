<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class EmployeeRelease extends Model
{

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function release_type()
    {
        return $this->belongsTo(ReleasedType::class, 'released_type_id', 'id');
    }
}
