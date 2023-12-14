<?php

namespace App\Boq\Departments\Sanitary;

use App\SanitaryFormulaDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryFormula extends Model
{
    use HasFactory;

    protected $fillable = ['location_type','location_for'];

    public function sanitaryFormulaDetails()
    {
        return $this->hasMany(SanitaryFormulaDetail::class);
    }
}
