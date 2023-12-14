<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = ['purchase_id','purchase_order_detail_id','raw_material_id','unit_id','quantity','unit_kg','unit_ltr','product_price','unite_price',
        'unite_price_lt','density','lc_cost','totalPrice'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function purchaseOrderDetail()
    {
        return $this->belongsTo(PurchaseOrderDetail::class);
    }
    public function rowMetarials()
    {
        return $this->belongsTo(Material::class,'raw_material_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
