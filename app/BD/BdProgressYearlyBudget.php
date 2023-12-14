<?php

namespace App\BD;

use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdProgressYearlyBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress_cost_center_id', 
        'progress_particulers', 
        'progress_amount', 
        'progress_january', 
        'progress_february', 
        'progress_march',
        'progress_april',
        'progress_may',
        'progress_june',
        'progress_july',
        'progress_august',
        'progress_september',
        'progress_october',
        'progress_november',
        'progress_december',
        'progress_remarks'
    ];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'progress_cost_center_id', 'id');
    }
}
