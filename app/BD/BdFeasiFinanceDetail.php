<?php

namespace App\BD;

use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiFinanceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'bd_feasi_finance_id',     
        'schedule_no',     
        'month',
        'amount',
        'sales_revenue_inflow',
        'cash_outflow',
        'outflow_rate',
        'inflow_rate',
        'outflow',
        'inflow',
        'net',
        'interest',
        'cumulitive'
    ];

    public function bd_feasi_finance(){
        return $this->belongsTo(BdFeasiFinance::class,'bd_feasi_finance_id');
    }

    protected $casts = [
        'amount'  => CommaToFloat::class,
        'outflow'   => CommaToFloat::class,
        'inflow'   => CommaToFloat::class,
        'net'   => CommaToFloat::class,
        'cumulitive'   => CommaToFloat::class,
    ];
}
