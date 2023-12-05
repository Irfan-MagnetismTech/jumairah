<?php

namespace App;

use App\Accounts\Account;
use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    use HasFactory;

    protected $fillable=['transaction_id','account_id','dr_amount','cr_amount','person_id','ref_bill','cost_center_id',
                        'remarks','pourpose','bill_status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id');
    }
    protected $casts = [
        'dr_amount'  => CommaToFloat::class,
        'cr_amount'   => CommaToFloat::class,
    ];

}
