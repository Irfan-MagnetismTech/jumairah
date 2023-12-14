<?php

namespace App\Boq\Configurations;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Procurement\NestedMaterial;
use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqMaterialFormula extends Model
{
    use HasFactory;

    protected $fillable = ['nested_material_id', 'work_id', 'project_id', 'percentage_value','wastage', 'is_multiply_calc_no'];

    public function material(): HasOne
    {
        return $this->hasOne(NestedMaterial::class, 'id', 'nested_material_id')
            ->withDefault();
    }

    public function civilBudget(): HasOne
    {
        return $this->hasOne(BoqCivilBudget::class, 'nested_material_id', 'nested_material_id')
            ->where(
                [
                    'project_id'=> request('project_id'),
                    'boq_work_id' => request('work_id'),
                    'boq_floor_id' => request('boq_floor_id'),
                    'budget_type' => request('budget_type'),
                ]
            );
    }

    public function work(): HasOne
    {
        return $this->hasOne(BoqWork::class, 'id', 'work_id')
            ->withDefault();
    }

}
