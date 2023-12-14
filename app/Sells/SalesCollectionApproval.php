<?php

namespace App\Sells;
use App\Accounts\Account;
use App\SalesCollection;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCollectionApproval extends Model
{
    use HasFactory;
    protected $fillable = ['salecollection_id','approval_status','approval_date','bank_account_id','sundry_creditor_account_id','reason'];

    public function salecollection()
    {
        return $this->belongsTo(SalesCollection::class, 'salecollection_id')->withDefault();
    }

    public function bancAccount()
    {
        return $this->belongsTo(Account::class, 'bank_account_id')->withDefault();
    }

    public function sundryCreditor()
    {
        return $this->belongsTo(Account::class,'sundry_creditor_account_id')->withDefault();
    }

    public function setApprovalDateAttribute($input)
    {
        $this->attributes['approval_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getApprovalDateAttribute($input)
    {
        $approval_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $approval_date;
    }

}
