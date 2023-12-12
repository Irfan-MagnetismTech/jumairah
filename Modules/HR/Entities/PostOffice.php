<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class PostOffice extends Model
{
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function police_station()
    {
        return $this->belongsTo(PoliceStation::class);
    }
    public function employeeaddress()
    {
        return $this->hasMany(EmployeeAddress::class, 'po_id', 'id');
    }
}
