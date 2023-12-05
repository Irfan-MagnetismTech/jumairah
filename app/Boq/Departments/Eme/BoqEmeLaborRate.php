<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Project;
use App\Approval\Approval;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeLaborRate extends Model
{
    use HasFactory;
    protected $fillable = ['second_layer_parent_id','note','project_id','description','basis_of_measurement','type','applied_by'];

    /**
     * Get all of the comments for the BoqEmeLaborRate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labor_rate_details(): HasMany
    {
        return $this->hasMany(BoqEmeLaborRateDetail::class,'boq_eme_labor_rate_id','id');
    }

    public function NestedMaterialSecondLayer(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'second_layer_parent_id', 'id')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        BoqEmeLaborRate::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
