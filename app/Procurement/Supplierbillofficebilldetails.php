<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbillofficebilldetails extends Model
{
    use HasFactory;
    protected $fillable = ['mrr_no', 'po_no','mpr_no','supplier_id', 'supplierbill_id', 'amount','remarks'];

    public function supplierbill(){
        return $this->belongsTo(Supplierbill::class,'supplierbill_id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id', 'id');
    }

    public function materialReceive()
    {
        return $this->belongsTo(MaterialReceive::class,'mrr_no','mrr_no');
    }
}
