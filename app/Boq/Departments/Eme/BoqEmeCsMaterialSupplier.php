<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\NestedMaterial;
use App\Procurement\Supplier;

class BoqEmeCsMaterialSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'boq_eme_cs_id',
        'boq_eme_cs_material_id',
        'boq_eme_cs_supplier_id',
        'price'
    ];
    public function Csmaterial()
    {
        return $this->belongsTo(BoqEmeCsMaterial::class,'boq_eme_cs_material_id');
    }

    public function Cssupplier()
    {
        return $this->belongsTo(CsSupplier::class,'boq_eme_cs_supplier_id','id');
    }

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class);
    }

    /**
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
