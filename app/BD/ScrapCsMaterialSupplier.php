<?php

namespace App\BD;

use App\Procurement\Supplier;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\BD\ScrapCs;

class ScrapCsMaterialSupplier extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['scrap_cs_id', 'scrap_cs_material_id', 'scrap_cs_supplier_id', 'price'];

    /**
     * @return mixed
     */

    public function Cs()
    {
        return $this->belongsTo(ScrapCs::class,'scrap_cs_id');
    }

    public function Csmaterial()
    {
        return $this->belongsTo(ScrapCsMaterial::class,'scrap_cs_material_id');
    }

    public function Cssupplier()
    {
        return $this->belongsTo(ScrapCsSupplier::class,'scrap_cs_supplier_id');
    }



}
