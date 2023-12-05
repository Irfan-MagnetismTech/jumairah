<?php

namespace App\Billing;

use App\Procurement\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCsSupplier extends Model
{
    use HasFactory;

    protected $fillable = ['work_cs_id', 'supplier_id', 'is_checked', 'vat', 'advanced'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }

}
