<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    
    protected $guarded = [];

    public function leave_balance_details()
    {
        return $this->hasOne(LeaveBalanceDetail::class, 'leave_balance_id', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id' , 'id');
    }

}
