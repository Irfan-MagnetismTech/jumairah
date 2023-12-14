<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasibilityEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'user_id',
        'total_payment',
        'rfpl_ratio',
        'registration_cost',
        'adjacent_road_width',
        'parking_area_per_car',
        'building_front_length',
        'floor_number',
        'fire_stair_area',
        'parking_number',
        'construction_life_cycle',
        'parking_sales_revenue',
        // 'semi_basement_floor_area',
        // 'ground_floor_area',
        'apertment_number',
        'floor_area_far_free',
        'bonus_saleable_area',
        'costing_value',
        'parking_rate',
        'basement_no'
    ];

    public function BdLeadGeneration()
    {
        return $this->belongsTo(BdLeadGeneration::class,'location_id', 'id');
    }


    public function ProjectLayout()
    {
        return $this->belongsTo(ProjectLayout::class, 'location_id','bd_lead_location_id');
    }

    public function BdFeasibilityCtc()
    {
        return $this->belongsTo(BdFeasibilityCtc::class, 'location_id','location_id');
    }

    public function BdFeasiRevenue()
    {
        return $this->belongsTo(BdFeasiRevenue::class, 'location_id','location_id');
    }

    public function BdFeasiFessAndCost()
    {
        return $this->belongsTo(BdFeasiFessAndCost::class, 'location_id','location_id');
    }
}
