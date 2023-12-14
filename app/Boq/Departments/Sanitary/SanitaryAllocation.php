<?php

namespace App\Boq\Departments\Sanitary;

use App\Project;
use App\ProjectType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryAllocation extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','apartment_type','location_type','owner_quantity','fc_quantity'];

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    public function apartmentType()
    {
        return $this->belongsTo(ProjectType::class,'apartment_type','composite_key')->withDefault();
    }

    public function scopeCommercial($query)
    {
        return $query->where('type', 'Commercial');
    }
    public function scopeResidential($query)
    {
        return $query->where('type', 'Residential');
    }
}
