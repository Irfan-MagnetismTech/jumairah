<?php

namespace App;

use App\Accounts\BankReconciliation;
use App\Accounts\PaidBill;
use App\Casts\CommaToFloat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=['voucher_type','transaction_date','narration','document_id','transactionable_id','transactionable_type',
                        'challan_no','cheque_number','cheque_type','cheque_date','bill_no','mr_no','user_id'];

    public function paidBill()
    {
        return $this->hasMany(LedgerEntry::class,'ref_bill','bill_no');
    }
    public function paidBills()
    {
        return $this->hasMany(PaidBill::class,'ref_bill','bill_no');
    }

    public function paidBillTransections()
    {
        return $this->hasMany(PaidBill::class);
    }

    public function bankReconciliation()
    {
        return $this->hasOne(BankReconciliation::class,'transaction_id','id');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function setTransactionDateAttribute($input)
    {
        !empty($input) ? $this->attributes['transaction_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getTransactionDateAttribute($input)
    {
        $transaction_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $transaction_date;
    }

    public function setChequeDateAttribute($input)
    {
        !empty($input) ? $this->attributes['cheque_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getChequeDateAttribute($input)
    {
        return  !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
