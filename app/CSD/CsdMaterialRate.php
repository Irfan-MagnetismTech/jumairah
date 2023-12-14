<?php

namespace App\CSD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsdMaterialRate extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'unit_id', 'actual_rate', 'demand_rate', 'refund_rate'];

    public function csdMaterials()
    {
        return $this->belongsTo(CsdMaterial::class, 'material_id', 'id')->withDefault();
    }
}
