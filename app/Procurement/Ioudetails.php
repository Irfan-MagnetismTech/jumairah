<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Billing\Workorder;

class Ioudetails extends Model
{
    use HasFactory;
    protected $fillable = ['iou_id','purpose','po_no','remarks','amount','workorder_id'];

    public function iou(){
        return $this->belongsTo(Iou::class);
    }

    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function workorder()
    {
        return $this->belongsTo(Workorder::class,'workorder_id');
    }
}
