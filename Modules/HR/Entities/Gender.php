<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    
    protected $guarded = [];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'gender_id', 'id');
    }
}
