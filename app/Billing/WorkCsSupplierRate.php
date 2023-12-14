<?php

namespace App\Billing;

use App\Procurement\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCsSupplierRate extends Model
{
    use HasFactory;

    protected $fillable = ['work_cs_id', 'work_cs_supplier_id', 'work_cs_line_id', 'price'];
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'work_cs_supplier_id', 'id');
    }
    public function workCsLine()
    {
        return $this->belongsTo(WorkCsLine::class, 'work_cs_line_id', 'id');
    }    
    
}
