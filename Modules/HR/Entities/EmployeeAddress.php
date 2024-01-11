<?php

namespace Modules\HR\Entities;

use App\District;
use App\Division;
use Modules\HR\Entities\PostOffice;
use Modules\HR\Entities\PoliceStation;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function police_station()
    {
        return $this->belongsTo(PoliceStation::class, 'ps_id', 'id');
    }

    public function post_office()
    {
        return $this->belongsTo(PostOffice::class, 'po_id', 'id');
    }
}
