<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CostCenter;


class BdFutureBudget extends Model
{
    use HasFactory;
    protected $fillable = ['future_cost_center_id', 'future_particulers', 'future_amount', 'future_remarks'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'future_cost_center_id', 'id');
    }

}
