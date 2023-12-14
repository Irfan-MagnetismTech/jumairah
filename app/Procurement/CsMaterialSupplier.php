<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CsMaterialSupplier extends Model
{
    use HasFactory;

    // protected $table = 'procurement_supplier_material';

    /**
     * @var array
     */
    protected $fillable = ['cs_id', 'cs_material_id', 'cs_supplier_id', 'price'];

    /**
     * @return mixed
     */
    public function Csmaterial()
    {
        return $this->belongsTo(CsMaterial::class,'cs_material_id','id');
    }

    public function Cssupplier()
    {
        return $this->belongsTo(CsSupplier::class,'cs_supplier_id','id');
    }

    public function nestedMaterial()
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
