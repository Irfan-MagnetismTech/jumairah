<?php

namespace App\BD;

use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFutureYearlyBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'future_cost_center_id', 
        'future_particulers', 
        'future_amount', 
        'future_january', 
        'future_february', 
        'future_march',
        'future_april',
        'future_may',
        'future_june',
        'future_july',
        'future_august',
        'future_september',
        'future_october',
        'future_november',
        'future_december',
        'future_remarks'
    ];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'future_cost_center_id', 'id');
    }

}
