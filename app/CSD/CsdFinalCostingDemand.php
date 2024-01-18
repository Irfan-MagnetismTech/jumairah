<?php

namespace App\CSD;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsdFinalCostingDemand extends Model
{
    use HasFactory;
    protected $fillable = ['csd_final_costing_id', 'material_id', 'unit_id', 'demand_rate', 'quantity', 'amount'];

    public function csdMaterials()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id');
    }

    public function csdFinalCosting()
    {
        return $this->belongsTo(CsdFinalCosting::class)->withDefault();
    }
}
