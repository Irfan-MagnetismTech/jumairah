<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class ProcessedBonusDetail extends Model
{
   
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function processedBonus()
    {
        return $this->belongsTo(ProcessedBonus::class,'processed_bonus_id');
    }



}
