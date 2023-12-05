<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Departments\Civil\BoqCivilCalcDetail;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqCivilCalcGroupMaterial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['boq_civil_calc_group_id', 'material_id', 'material_price', 'material_ratio', 'material_wastage'];


    public function boqCivilCalcGroupMaterial(): HasOne
    {
        return $this->hasOne(NestedMaterial::class, 'id', 'material_id');
    }
}
