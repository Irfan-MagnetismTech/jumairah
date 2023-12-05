<?php

namespace App\Boq\Configurations;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqMaterialPriceWastage extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['nested_material_id', 'project_id', 'price', 'wastage', 'is_other_cost', 'other_material_head'];

    /**
     * @return mixed
     */
    public function material(): HasOne
    {
        return $this->hasOne(NestedMaterial::class, 'id', 'nested_material_id')
            ->withDefault();
    }

    /**
     * Belongs to nested material.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nestedMaterial(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'nested_material_id')
            ->withDefault();
    }

    public function boqCivilBudget(): HasOne
    {
        return $this->hasOne(BoqCivilBudget::class, 'nested_material_id', 'nested_material_id')
            ->withDefault();
    }
}
