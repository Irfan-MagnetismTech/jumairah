<?php

namespace App\Procurement;

use App\Accounts\FixedAsset;
use Illuminate\Database\Eloquent\Model;

class Materialmovementdetail extends Model
{
    protected $fillable = [ 'materialmovement_id','movement_requision_id','fixed_asset_id','gate_pass','material_id','quantity','remarks'];

    public function movement(){
        return $this->belongsTo(Materialmovement::class);
    }

    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function movementRequisition(){
        return $this->belongsTo(MovementRequisition::class, 'movement_requision_id')->withDefault();
    }

    public function fixedAsset(){
        return $this->belongsTo(FixedAsset::class, 'fixed_asset_id')->withDefault();
    }
}
