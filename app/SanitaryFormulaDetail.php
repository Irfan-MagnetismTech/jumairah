<?php

namespace App;

use App\Boq\Departments\Sanitary\SanitaryFormula;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryFormulaDetail extends Model
{
    use HasFactory;

    protected $fillable = ['material_id','multiply_qnt','additional_qnt','formula','sanitary_formula_id'];

    public function sanitaryFormula()
    {
        return $this->belongsTo(SanitaryFormula::class)->withDefault();
    }

    public function material()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id','id');
    }
}
