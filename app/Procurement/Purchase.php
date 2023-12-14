<?php

namespace App\Procurement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id','lc_type','purchase_order_id','purchase_type','LC_number','lc_receiving_date','lc_weight','bl_weight','receiving_weight','lc_opening_date','date',
                        'warehouse_id','remarks','issue_bank','advising_bank','negotiate_bank','total_amount','lc_amount','tt_amount',
                        'vat','discount','invoice_img','user_id','section_id'];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function purchaseLcCost()
    {
        return $this->hasMany(PurchaseLcCost::class);
    }
    public function supplierPayment()
    {
        return $this->hasMany(SupplierPayment::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function issuebank()
    {
        return $this->belongsTo(Bank::class,'issue_bank');
    }
    public function advisingbank()
    {
        return $this->belongsTo(Bank::class,'advising_bank');
    }
    public function negotiatebank()
    {
        return $this->belongsTo(Bank::class,'negotiate_bank');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function setDateAttribute($input)
    {
        if (!empty($input)){
            $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d');
        }
    }
//    public function getDateAttribute($input)
//    {
//        if (!empty($input)){
//            return  Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
//        }
//    }

    public function setLcOpeningDateAttribute($input)
    {
        if (!empty($input)){
            $this->attributes['lc_opening_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d');
        }
    }

//    public function getLcOpeningDateAttribute($input)
//    {
//        return Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d');
//    }
    public function setLcReceivingDateAttribute($input)
    {
        if (!empty($input)){
            $this->attributes['lc_receiving_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d');
        }
    }

}

