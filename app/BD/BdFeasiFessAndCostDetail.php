<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasiFessAndCostDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'headble_id',
        'headble_type',
        'calculation',
        'rate',
        'quantity',
        'remarks'
    ];

    public function headable(){
        return $this->morphTo('','headble_type','headble_id');
    }

    public function BdFeasiFessAndCost(){
        return $this->belongsTo(BdFeasiFessAndCost::class, 'fess_and_cost_id', 'id');
    }


}
