<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqEmeCsSupplierOptions extends Model
{
    use HasFactory;
    protected $fillable = [
        'boq_eme_cs_supplier_id',
        'boq_eme_cs_supplier_eval_field_id',
        'value'
    ];
    public function options()
    {
        return $this->belongsTo(BoqEmeCsSupplierEvalField::class,'boq_eme_cs_supplier_eval_field_id');
    }
    
}
