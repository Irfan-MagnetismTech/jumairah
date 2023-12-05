<?php

namespace App\Procurement;

use App\Boq\Projects\BoqFloorProject;
use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqSupremeBudget extends Model
{
    use HasFactory;
    protected $fillable = ['budget_for', 'project_id', 'budget_type', 'floor_id', 'material_id', 'quantity', 'remarks'];

    public function boqFloorProject(): BelongsTo
    {
        return $this->belongsTo(BoqFloorProject::class, 'floor_id', 'boq_floor_project_id')->withDefault();
    }

    public function nestedMaterial(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id')->withDefault();
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'project_id','project_id')->withDefault();
    }

    public function boqCivilCalcProjectFloor(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'floor_id');
    }
}
