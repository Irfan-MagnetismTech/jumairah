<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasibilityFar extends Model
{
    use HasFactory;
    protected $fillable = [
        'bd_leadgeneration_id', 
        'land_size_katha', 
        'road_feet',
        'road_meter',
        'far',
        'max_ground_coverage'
    ];

}
