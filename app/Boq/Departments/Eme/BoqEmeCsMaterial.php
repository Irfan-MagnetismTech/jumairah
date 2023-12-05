<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\NestedMaterial;

class BoqEmeCsMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['boq_eme_cs_id','material_id'];

    public function cs()
    {
        return $this->belongsTo(BoqEmeCs::class,'boq_eme_cs_id');
    }

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }
}
