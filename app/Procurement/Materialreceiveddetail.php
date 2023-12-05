<?php

namespace App\Procurement;

use App\Boq\Configurations\BoqFloor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materialreceiveddetail extends Model
{
    use HasFactory;
    protected $fillable =['floor_id','material_id','quantity','material_receive_id','brand','origin','challan_no', 'mrr_challan_key', 'ledger_folio_no','purpose','rate'];

    public function materialReceive(){
        return $this->belongsTo(MaterialReceive::class,  'material_receive_id','id');
    }

    public function nestedMaterials(){
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function boqFloor(){
        return $this->belongsTo(BoqFloor::class, 'floor_id', 'id');
    }


}
