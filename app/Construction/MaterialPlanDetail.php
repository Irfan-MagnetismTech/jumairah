<?php

namespace App\Construction;

use App\Approval\Approval;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPlanDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'material_id', 
        'unit_id', 
        'week_one', 
        'week_two', 
        'week_three', 
        'week_four', 
        'remarks', 
        'total_quantity', 
        'week_one_rate', 
        'week_two_rate', 
        'week_three_rate', 
        'week_four_rate'
    ];

    public function nestedMaterials()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id');
    }
    public function materialPlan()
    {
        return $this->belongsTo(MaterialPlan::class, 'material_plan_id', 'id' );
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
}
