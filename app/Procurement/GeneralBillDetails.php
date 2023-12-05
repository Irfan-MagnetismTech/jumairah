<?php

namespace App\Procurement;

use App\Procurement\GeneralBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Accounts\Account;

class GeneralBillDetails extends Model
{
    use HasFactory;

    protected $fillable=['general_bill_id','account_id','description','attachment','amount', 'remarks'];

    public function generalBill(){
        return $this->belongsTo(GeneralBill::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
