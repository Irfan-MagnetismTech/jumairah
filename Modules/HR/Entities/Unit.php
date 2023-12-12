<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'unit_id', 'id');
    }
}
