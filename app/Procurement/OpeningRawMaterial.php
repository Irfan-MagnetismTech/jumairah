<?php

namespace App\Procurement;

use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningRawMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['cost_center_id','applied_date','entry_by'];


    public function OpeningRawMaterialDetails()
    {
        return $this->hasMany(OpeningRawMaterialDetails::class, 'opening_material_id','id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id','id');
    }

    public function NestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id','id');
    }
}
