<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Division;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class,'division_id')->withDefault();
    }

    public function policestations()
    {
        return $this->hasMany(PoliceStation::class, 'district_id', 'id');
    }
}
