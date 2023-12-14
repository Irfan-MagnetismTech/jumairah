<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Projects\BoqFloorProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqReinforcementSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'boq_work_id',
        'boq_floor_id',
        'nested_material_id',
        'budget_type',
        'formula_percentage',
        'quantity',
        'wastage',
        'wastage_quantity',
        'rate',
        'dia',
        'calculation_total',
        'total_quantity',
        'total_amount',
        'boq_floor_type_id',
        'boq_work_parent_id',
    ];

    public function boqReinforcementProjectFloor(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'boq_floor_id');
    }
}
