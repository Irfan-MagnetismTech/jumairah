<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class AllowanceType extends Model
{
 
    protected $guarded = [];

    public function allowances()
    {
        return $this->hasMany(Allowance::class);
    }
}
