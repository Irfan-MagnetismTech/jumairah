<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Project;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeLoadCalculation extends Model
{
    use HasFactory;
    protected $fillable = ['project_type','calculation_type','total_connecting_wattage','demand_percent','total_demand_wattage','project_id','genarator_efficiency','applied_by'];

    public function boq_eme_load_calculations_details(){
        return $this->hasMany(BoqEmeLoadCalculationDetails::class,'eme_load_calculation_id','id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        BoqEmeLoadCalculation::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id')->withDefault();
    }
}
