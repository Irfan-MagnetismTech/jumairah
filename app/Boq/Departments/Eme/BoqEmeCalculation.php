<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Approval\Approval;
use App\Procurement\NestedMaterial;
use App\Boq\Projects\BoqFloorProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'budget_head_id',
        'item_id',
        'floor_id',
        'boq_eme_rate_id',
        'material_id',
        'material_rate',
        'labour_rate',
        'quantity',
        'total_material_amount',
        'total_labour_amount',
        'total_amount',
        'remarks',
        'applied_by'
    ];

    public function BoqFloorProject()
    {
        return $this->belongsTo(BoqFloorProject::class, 'floor_id','boq_floor_project_id')->withDefault();
    }
    public function NestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id')->withDefault();
    }
    public function NestedMaterialSecondLayer()
    {
        return $this->belongsTo(NestedMaterial::class, 'item_id')->withDefault();
    }

    public function BoqEmeRate()
    {
        return $this->belongsTo(BoqEmeRate::class, 'boq_eme_rate_id')->withDefault();
    }

    public function EmeBudgetHead()
    {
        return $this->belongsTo(EmeBudgetHead::class, 'budget_head_id')->withDefault();
    }
    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        BoqEmeCalculation::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
