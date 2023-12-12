<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'religion_id', 'id');
    }
}
