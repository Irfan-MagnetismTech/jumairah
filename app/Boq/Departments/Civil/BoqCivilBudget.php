<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Configurations\BoqFloorType;
use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Configurations\BoqWork;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\NestedMaterial;
use App\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqCivilBudget extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'project_id',
        'boq_work_id',
        'work_type_id',
        'boq_floor_id',
        'nested_material_id',
        'budget_type',
        'formula_percentage',
        'quantity',
        'wastage',
        'wastage_quantity',
        'rate',
        'total_quantity',
        'total_amount',
        'cost_head',
        'is_additional_material',
        'boq_floor_type_id',
        'boq_work_parent_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boqWork(): BelongsTo
    {
        return $this->belongsTo(BoqWork::class)->withDefault();
    }

    public function boqParentWork(): HasOne
    {
        return $this->hasOne(BoqWork::class,'id','boq_work_parent_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boqFloor(): BelongsTo
    {
        return $this->belongsTo(BoqFloor::class)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nestedMaterial(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class)->withDefault();
    }

    /**
     * @return mixed
     */
    public function boqCivilCalcProjectFloor(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'boq_floor_id');
    }

    /**
     * @return mixed
     */
    public function boqFloorProject(): BelongsTo
    {
        return $this->belongsTo(BoqFloorProject::class, 'boq_floor_id', 'boq_floor_project_id');
    }

    /**
     * @return mixed
     */
    public function workType(): BelongsTo
    {
        return $this->belongsTo(BoqWork::class, 'work_type_id', 'id')->withDefault();
    }

    public function boqCivilCalcFloorType(): HasOne
    {
        return $this->hasOne(BoqFloorType::class, 'id', 'boq_floor_type_id');
    }

    public function boqMaterialPriceWastage(): HasOne
    {
        return $this->hasOne(BoqMaterialPriceWastage::class, 'nested_material_id', 'nested_material_id');
    }

    //check a work is reinforcement or not
    public function isReinforcementWork()
    {
        return $this->boqWork->is_reinforcement;
    }
}
