<?php

namespace Modules\HR\Entities;

use App\Employee;
use Modules\HR\Entities\AllowanceType;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function allowance_type()
    {
        return $this->belongsTo(AllowanceType::class, 'allowance_type_id');
    }
}
