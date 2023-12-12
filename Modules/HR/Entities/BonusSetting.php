<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class BonusSetting extends Model
{
  

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function bonus()
    {
        return $this->belongsTo(Bonus::class,'bonus_id');
    }
}
