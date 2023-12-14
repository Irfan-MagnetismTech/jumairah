<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CostCenter;

class BdProgressBudget extends Model
{
    use HasFactory;

    protected $fillable = ['progress_cost_center_id', 'progress_particulers', 'progress_amount', 'progress_remarks'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'progress_cost_center_id', 'id');
    }
}
