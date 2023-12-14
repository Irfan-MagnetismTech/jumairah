<?php

namespace App\BD;

use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasiPerticular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     
        'unit_id',
        'type',
        'statuts'
    ];

    public function feesAndCosts(){
        return $this->morphOne(BdFeasiFessAndCostDetail::class,'headable','headble_type','headble_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    
}
