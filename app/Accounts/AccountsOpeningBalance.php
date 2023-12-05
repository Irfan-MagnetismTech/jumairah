<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use App\CostCenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsOpeningBalance extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'date','cost_center_id','dr_amount','cr_amount','user_id'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id');
    }

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date ;
    }
    protected $casts = [
        'date'              => 'datetime',
        'dr_amount'        => CommaToFloat::class,
        'cr_amount'        => CommaToFloat::class,
    ];

}
