<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class JobLocation extends Model
{
   
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'job_location_id', 'id');
    }
}
