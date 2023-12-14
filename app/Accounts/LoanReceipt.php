<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanReceipt extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id','receipt_amount','date','account_id','user_id'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function setDateAttribute($input){
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input){
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    protected $casts = [
        'receipt_amount'  => CommaToFloat::class,
    ];
}
