<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilCalcGroup;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqCivilCalc extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'work_id',
        'boq_floor_id',
        'calculation_type',
        'work_type',
        'total',
        'secondary_total',
        'secondary_total_fx',
        'unit_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boqCivilCalcGroups(): HasMany
    {
        return $this->hasMany(BoqCivilCalcGroup::class, 'boq_civil_calc_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boqCivilCalcDetails(): HasMany
    {
        return $this->hasMany(BoqCivilCalcDetail::class, 'boq_civil_calc_id', 'id');
    }

    /**
     * @return mixed
     */
    public function boqCivilCalcWork(): HasOne
    {
        return $this->hasOne(BoqWork::class, 'id', 'work_id');
    }

    /**
     * @return mixed
     */
    public function boqCivilCalcProjectFloor(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'boq_floor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id')
            ->withDefault();
    }
}
