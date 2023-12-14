<?php

namespace App\Procurement;

use App\Boq\Configurations\BoqFloor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storeissuedetails extends Model
{
    use HasFactory;
    protected $fillable =['storeissue_id','floor_id', 'material_id', 'notes', 'ledger_folio_no','purpose','issued_quantity'];

    public function storeissue(){
        return $this->belongsTo(Storeissue::class);
    }

    public function nestedMaterials(){
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function boqFloor(){
        return $this->belongsTo(BoqFloor::class, 'floor_id', 'id');
    }

}
