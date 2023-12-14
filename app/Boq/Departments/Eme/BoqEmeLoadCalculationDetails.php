<?php

namespace App\Boq\Departments\Eme;

use App\Procurement\NestedMaterial;
use App\Boq\Configurations\BoqFloor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeLoadCalculationDetails extends Model
{
    use HasFactory;
    protected $fillable = ['material_id','floor_id','load','qty','connected_load'];

    public function boq_eme_load_calculations(){
        return $this->belongsTo(BoqEmeLoadCalculation::class,'eme_load_calculation_id');
    }

    public function floor()
    {
        return $this->belongsTo(BoqFloor::class, 'floor_id')->withDefault();
    }

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }
}
