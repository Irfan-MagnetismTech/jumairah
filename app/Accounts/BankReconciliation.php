<?php

namespace App\Accounts;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankReconciliation extends Model
{
    use HasFactory;

    protected $fillable = ['date','transaction_id','user_id','status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        $transaction_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $transaction_date;
    }


}
