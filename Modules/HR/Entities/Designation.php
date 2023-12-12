<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Grade;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    // use \App\Traits\CreateComId;
    protected $guarded = [];

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id' , 'id');
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class, 'designation_id', 'id');
    }
}
