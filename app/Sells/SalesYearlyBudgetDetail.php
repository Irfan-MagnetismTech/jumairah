<?php

namespace App\Sells;

use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesYearlyBudgetDetail extends Model
{
    use HasFactory;

    protected $fillable = ['month','sales_value','booking_money'];

    public function salesYearlyBudget()
    {
        return $this->belongsTo(SalesYearlyBudget::class)->withDefault();
    }

    protected $casts = [
        'sales_value'     => CommaToFloat::class,
        'booking_money'   => CommaToFloat::class,
    ];
}
