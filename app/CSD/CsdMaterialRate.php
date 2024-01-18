<?php

namespace App\CSD;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsdMaterialRate extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'actual_rate', 'demand_rate', 'refund_rate'];

    public function csdMaterials()
    {
        return $this->belongsTo(CsdMaterial::class, 'material_id', 'id')->withDefault();
    }
    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id')->withDefault();
    }
}
