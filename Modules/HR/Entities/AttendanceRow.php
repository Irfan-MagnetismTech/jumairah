<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class AttendanceRow extends Model
{

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'emp_id');
    }

    public function device()
    {
        return $this->belongsTo(FingerPrintDeviceInfo::class,'device_id');
    }
}
