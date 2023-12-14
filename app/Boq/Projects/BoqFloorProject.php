<?php

namespace App\Boq\Projects;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Procurement\BoqSupremeBudget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqFloorProject extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $fillable = ['project_id', 'floor_id', 'area', 'boq_floor_project_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(BoqFloor::class, 'floor_id', 'id')->withDefault();
    }
    

    public function boqCommonFloor(): HasOne
    {
        return $this->hasOne(BoqFloor::class, 'id', 'floor_id');
    }

    public function boqCivilBudgets():HasMany
    {
        return $this->hasMany(BoqCivilBudget::class, 'boq_floor_id', 'boq_floor_project_id');
    }

    public function boqSupremeBudgets():HasMany
    {
        return $this->hasMany(BoqSupremeBudget::class, 'floor_id', 'boq_floor_project_id');
    }

}
