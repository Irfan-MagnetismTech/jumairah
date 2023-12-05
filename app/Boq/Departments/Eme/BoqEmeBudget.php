<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Project;
use App\Approval\Approval;
use App\Boq\Projects\BoqFloorProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'budget_head_id',
        'specification',
        'brand',
        'rate',
        'quantity',
        'amount',
        'applied_by'
    ];

    public function EmeBudgetHead()
    {
        return $this->belongsTo(EmeBudgetHead::class, 'budget_head_id','id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        BoqEmeBudget::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
