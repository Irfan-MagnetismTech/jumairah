<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\NestedMaterial;

class ScrapSaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'rate', 'quantity', 'remarks'];
    
    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class,'material_id')->withDefault();
    }
}
