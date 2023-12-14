<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use App\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidBill extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','account_id','cost_center_id','ref_bill','amount'];

    public function paidBill()
    {
        return $this->belongsTo(Transaction::class)->withDefault();
    }

    protected $casts = [
        'amount'  => CommaToFloat::class,
    ];
}
