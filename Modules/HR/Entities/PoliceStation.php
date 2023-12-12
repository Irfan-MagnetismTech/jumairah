<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\District;
use Illuminate\Database\Eloquent\Model;

class PoliceStation extends Model
{

    protected $guarded = [];

    public function districts()
    {
        return $this->belongsTo(District::class,'district_id')->withDefault();
    }

    public function postoffices()
    {
        return $this->hasMany(PostOffice::class, 'police_station_id', 'id');
    }
}
