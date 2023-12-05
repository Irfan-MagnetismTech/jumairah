<?php

namespace App\Accounts;

use App\SalaryDetail;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = ['month','user_id','status'];

    public function salaryDetails()
    {
        return $this->hasMany(SalaryDetail::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function getMonthAttribute($input)
    {
        $month = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('F Y') : null;
        return $month;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
