<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Bank;
use Modules\HR\Entities\PayMode;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\BankBranchInfo;

class EmployeeBankInfo extends Model
{
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id' , 'id');
    }



    public function paymode()
    {
        return $this->belongsTo(PayMode::class,'pay_mode_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(BankBranchInfo::class,'branch_id', 'id');
    }
}
