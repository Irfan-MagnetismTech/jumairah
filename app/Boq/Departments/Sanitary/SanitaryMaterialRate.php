<?php

namespace App\Boq\Departments\Sanitary;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryMaterialRate extends Model
{
    use HasFactory;

    protected $fillable = ['material_id','material_rate'];

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }
}
