<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLayout extends Model
{
    use HasFactory;
    protected $fillable = [
        'bd_lead_location_id', 
        'proposed_road_width', 
        'modified_far', 
        'total_far', 
        'proposed_mgc', 
        'total_basement_floor', 
        'front_verenda_feet', 
        'proposed_story',
        'grand_road_sft',
        'grand_far_sft',
        'actual_story',
        'front_ver_spc_per',
        'front_verenda_percent',
        'percentage',
        'side_ver_spc_per'
    ];

    public function road_details()
    {
        return $this->hasMany(Road_detail::class, 'project_layout_id');
    }

}
