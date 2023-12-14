<?php

namespace App\Procurement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_order_id','material_id','material_size','material_type','brand','quantity','unit_price','discount_price','total_price','required_date'];


    public function nestedMaterials()
    {
        return $this->belongsTo(NestedMaterial::class,'material_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function setRequiredDateAttribute($input)
    {
        $this->attributes['required_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;

    }

    public function getRequiredDateAttribute($input)
    {
        $required_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $required_date;
    }

}
