<?php

namespace App\Boq\Departments\Sanitary;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWiseMaterialDetails extends Model
{
    use HasFactory;

    protected $fillable = ['material_id','rate_type','quantity','material_rate'];

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id','id')->withDefault();
    }

    public function projectWiseMaterial()
    {
        return $this->belongsTo(ProjectWiseMaterial::class);
    }
}
