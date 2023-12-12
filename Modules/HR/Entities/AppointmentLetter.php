<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentLetter extends Model
{
  
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class,'letter_creator_id');
    }
}
