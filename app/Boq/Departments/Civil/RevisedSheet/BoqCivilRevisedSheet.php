<?php

namespace App\Boq\Departments\Civil\RevisedSheet;

use App\Boq\Projects\BoqFloorProject;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BoqCivilRevisedSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'boq_floor_id',
        'nested_material_id',
        'escalation_no',
        'escalation_date',
        'budget_for',
        'budget_type',
        'primary_qty',
        'primary_price',
        'primary_amount',
        'used_qty',
        'current_balance_qty',
        'revised_qty',
        'revised_price',
        'price_after_revised',
        'qty_after_revised',
        'amount_after_revised',
        'increased_or_decreased_amount',
        'remarks',
        'till_date',
    ];


    public function material(): HasOne
    {
        return $this->hasOne(NestedMaterial::class, 'id', 'nested_material_id')
            ->withDefault();
    }

    public function floorProject(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'boq_floor_id')
            ->withDefault();
    }
}
