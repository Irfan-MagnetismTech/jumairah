<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\Account;

class Bank extends Model
{
    protected $guarded = [];

    public function employeeBankInfo()
    {
        return $this->hasMany(EmployeeBankInfo::class, 'bank_id', 'id');
    }
    public function employee_bank_info()
    {
        return $this->hasMany(BankBranchInfo::class, 'bank_id', 'id');
    }

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }
}
