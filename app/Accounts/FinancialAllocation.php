<?php

namespace App\Accounts;

use App\Approval\Approval;
use App\Casts\CommaToFloat;
use App\CostCenter;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAllocation extends Model
{
    use HasFactory;

    protected $fillable = ['from_month',    'to_month',    'sod_amount',    'hbl_amount',    'user_id'];

    public function financialAllocationDetails(){
        return $this->hasMany(FinancialAllocationDetail::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function getFromMonthAttribute($input)
    {
        $from_month = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('F Y') : null;
        return $from_month;
    }

    public function getToMonthAttribute($input)
    {
        $to_month = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('F Y') : null;
        return $to_month;
    }



    protected $casts = [
        'sod_amount'  => CommaToFloat::class,
        'hbl_amount'   => CommaToFloat::class,
    ];
}
