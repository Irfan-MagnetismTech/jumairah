<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\Supplier;

class BoqEmeCsSupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'boq_eme_cs_id',
        'supplier_id',
        'is_checked'
    ];

      /**
     * @return mixed
     */
    public function cs()
    {
        return $this->belongsTo(BoqEmeCs::class,'boq_eme_cs_id');
    }

    public function csSupplierOptions(){
        return $this->hasMany(BoqEmeCsSupplierOptions::class,'boq_eme_cs_supplier_id');
    }

    /**
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }
}
