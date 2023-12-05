<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbillpodetails extends Model
{
    use HasFactory;
    protected $fillable = ['po_id','supplier_name',];

    public function supplierbill(){
        return $this->belongsTo(Supplierbill::class,'supplier_bill_id');
    }

//    public function supplier(){
//        return $this->belongsTo(Supplier::class,'supplier_name');
//    }


}
