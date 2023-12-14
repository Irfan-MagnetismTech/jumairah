<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Departments\Civil\BoqCivilCalcDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqCivilCalcGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['boq_civil_calc_id', 'name', 'total'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boqCivilCalcDetails(): HasMany
    {
        return $this->hasMany(BoqCivilCalcDetail::class, 'boq_civil_calc_group_id', 'id');
    }

    public function boqCivilCalc(): HasOne
    {
        return $this->hasOne(BoqCivilCalc::class, 'id', 'boq_civil_calc_id');
    }

    public function boqCivilCalcGroupMaterials(): HasMany
    {
        return $this->hasMany(BoqCivilCalcGroupMaterial::class, 'boq_civil_calc_group_id', 'id');
    }
}
