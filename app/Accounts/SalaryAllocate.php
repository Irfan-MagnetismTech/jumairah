<?php

namespace App\Accounts;

use App\AllocationDetail;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllocate extends Model
{
    use HasFactory;

    protected $fillable = ['salary_id','month','user_id','status'];

    public function salary()
    {
        return $this->belongsTo(Salary::class)->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function salaryAllocateDetails()
    {
        return $this->hasMany(SalaryAllocateDetail::class);
    }

    public function getMonthAttribute($input)
    {
        $month = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('F Y') : null;
        return $month;
    }
}
