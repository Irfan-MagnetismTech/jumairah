<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasiRevenue extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id',
        'user_id',
        'revenue_from_parking',
        'avg_rate',
        'total_floor_sft',
        'total_amount',
        'total_saleable_sft',
        'ground_floor_sft',
        'mgc',
        'actual_story',
        'proposed_saleable_sft',
        'proposed_far',
        'actual_far'
    ];

    public function BdFeasiRevenueDetail(){
        return $this->hasMany(BdFeasiRevenueDetail::class, 'revenue_id', 'id');
    }

    public function BdLeadGeneration(){
        return $this->belongsTo(BdLeadGeneration::class, 'location_id', 'id');
    }
}
