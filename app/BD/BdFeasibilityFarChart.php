<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasibilityFarChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'land_category', 
        'start_land_sqr_meeter', 
        'end_land_sqr_meeter', 
        'start_land_size_katha', 
        'end_land_size_katha', 
        'road_meter',
        'far',
        'max_ground_coverage'
    ];
}
