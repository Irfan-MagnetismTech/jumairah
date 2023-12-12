<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Bank;
use Illuminate\Database\Eloquent\Model;

class BankBranchInfo extends Model
{
  
    protected $guarded = [];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function employeebankBranchs()
    {
        return $this->hasMany(EmployeeBankInfo::class, 'branch_id', 'id');
    }
}
