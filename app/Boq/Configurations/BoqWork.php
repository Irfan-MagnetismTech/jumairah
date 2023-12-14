<?php

namespace App\Boq\Configurations;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kalnoy\Nestedset\NodeTrait;

class BoqWork extends Model
{
    use HasFactory, NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'parent_id', 'unit_id', 'material_unit', 'labour_unit', 'material_labour_unit', 'is_reinforcement', 'is_multiply_calc_no',
        'labour_budget_type','calculation_type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materialUnit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'material_unit')
            ->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labourUnit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'labour_unit')
            ->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materialLabourUnit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'material_labour_unit')
            ->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boqMaterialFormulas(): HasMany
    {
        return $this->hasMany(BoqMaterialFormula::class, 'work_id', 'id');
    }

    public function boqCivilBudgetMaterials(): HasMany
    {
        return $this->hasMany(BoqCivilBudget::class, 'boq_work_parent_id', 'id');
    }

    public function boqWorkUnit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }


    // Root of a node
    /**
     * @return mixed
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    // with depth 1 (children of root)
    /**
     * @return mixed
     */
    public function isChild(): bool
    {
        return $this->depth === 1;
    }

    /**
     * @return mixed
     */
    public function getRootNode()
    {
        return $this->isRoot() ? $this : $this->parent->getRootNode();
    }

    /**
     * @return mixed
     */
    public function floorTypes()
    {
        return $this->belongsToMany(BoqFloorType::class);
    }

}
