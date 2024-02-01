<?php

namespace Modules\HR\Entities;

use App\Employee;
use Modules\HR\Entities\LoanType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function loan_type()
    {
        return $this->belongsTo(LoanType::class, 'loan_type_id', 'id');
    }
}
