<?php

namespace App\CSD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsdFinalCostingRefund extends Model
{
    use HasFactory;
    protected $fillable = ['csd_final_costing_id', 'material_id_refund', 'unit_id_refund', 'refund_rate', 'quantity_refund', 'amount_refund'];

    public function csdMaterials()
    {
        return $this->belongsTo(CsdMaterial::class, 'material_id_refund', 'id');
    }


    public function csdFinalCosting()
    {
        return $this->belongsTo(CsdFinalCosting::class,'csd_final_costing_id')->withDefault();
    }
}
