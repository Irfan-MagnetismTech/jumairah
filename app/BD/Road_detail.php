<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_layout_id', 'road_width', 'land_width', 'additional_far','existing_road','proposed_road'
    ];
}
