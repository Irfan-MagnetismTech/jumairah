<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
   
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'floor_id', 'id');
    }
    public function buildingInfo()
    {
        return $this->belongsTo(BuildingInfo::class, 'building_info_id' , 'id');
    }
}
