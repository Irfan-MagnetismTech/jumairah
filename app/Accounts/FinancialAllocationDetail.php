<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAllocationDetail extends Model
{
    use HasFactory;

    protected $fillable = ['financial_allocation_id',    'cost_center_id',    'sod_allocate_amount',    'hbl_allocate_amount',
        'total_allocation'];

    public function costCenter(){
        return $this->belongsTo(CostCenter::class,'cost_center_id');
    }

    protected $casts = [
        'sod_allocate_amount'  => CommaToFloat::class,
        'hbl_allocate_amount'   => CommaToFloat::class,
        'total_allocation'   => CommaToFloat::class,
    ];
}
