<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementRequisitionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['movement_requisition_id','material_id','quantity'];

    public function movementRequisition(){
        return $this->belongsTo(MovementRequisition::class);
    }

    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class, 'material_id');
    }
}
