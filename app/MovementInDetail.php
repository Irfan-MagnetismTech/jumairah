<?php

namespace App;

use App\Procurement\MovementIn;
use App\Procurement\MovementRequisition;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementInDetail extends Model
{
    use HasFactory;

    protected $fillable = ['movement_in_id','movement_requisition_id','material_id','mti_quantity','damage_quantity','remarks'];

    public function movementIn(){
        return $this->belongsTo(MovementIn::class)->withDefault();
    }

    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class,'material_id')->withDefault();
    }

    public function movementRequisition(){
        return $this->belongsTo(MovementRequisition::class, 'movement_requisition_id')->withDefault();
    }
}
