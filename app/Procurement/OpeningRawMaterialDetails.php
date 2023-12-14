<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningRawMaterialDetails extends Model
{
    use HasFactory;
    protected $fillable = ['opening_material_id', 'material_id','quantity'];

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }
}
