<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class BuildingInfo extends Model
{
   
    protected $guarded = [];

    public function floors()
    {
        return $this->hasMany(Floor::class, 'building_info_id', 'id');
    }
}
