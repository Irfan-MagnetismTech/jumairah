<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name','category_id','unit_id'];


    public function category()
    {
        return $this->belongsTo(Materialcategory::class)->withDefault();
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }

    public function materialBudgetDetails()
    {
        return $this->hasMany(Materialbudgetdetail::class, 'material_id');
    }

    public function requisitionDetails()
    {
        return $this->hasMany(Requisitiondetails::class, 'material_id');
    }

    public function scopeNotInPo($query, $mpr_no = null)
    {
        $purchase_order_materials = PurchaseOrderDetail::whereHas('purchaseOrder', function ($query) use ($mpr_no) {
            $query->where('mpr_no', $mpr_no);
        })
        ->get()
        ->pluck('material_id');

        $query->whereHas('requisitionDetails.requisition', function ($query) use ($mpr_no) {
            return $query->where('id', $mpr_no);
        })
        ->whereHas('requisitionDetails', function ($query) use ($purchase_order_materials) {
            return $query->whereNotIn('material_id', $purchase_order_materials);
        });
    }

}
