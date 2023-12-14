<?php

namespace App\BD;

use App\User;
use App\Approval\Approval;
use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',     
        'rate',
        'user_id',
        'inflow_amount',
        'outflow_amount',
        'total_interest'
    ];

    public function financeDetails(){
        return $this->hasMany(BdFeasiFinanceDetail::class, 'bd_feasi_finance_id');
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function BdLeadGeneration(){
        return $this->belongsTo(BdLeadGeneration::class, 'location_id', 'id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected $casts = [
        'inflow_amount'  => CommaToFloat::class,
        'outflow_amount'   => CommaToFloat::class
    ];
}
