<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Procurement\Iou;
use App\Approval\Approval;
use App\Procurement\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeWorkOrder extends Model
{
    use HasFactory;

    protected $fillable = ['workorder_for', 'issue_date', 'boq_eme_cs_id', 'workorder_no', 'supplier_id', 'deadline', 'remarks', 'description', 'involvement', 'workrate', 'prepared_by', 'total_amount', 'project_id'];


    public function setIssueDateAttribute($input)
    {
        !empty($input) ? $this->attributes['issue_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getIssueDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }
    public function workCs()
    {
        return $this->belongsTo(BoqEmeCs::class, 'boq_eme_cs_id')->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id')->withDefault();
    }

    public function terms()
    {
        return $this->hasOne(BoqEmeWorkorderTerm::class);
    }


    public function workSpecification()
    {
        return $this->hasMany(BoqEmeWorkSpecification::class);
    }

    public function workOtherFeature()
    {
        return $this->hasOne(BoqEmeWorkOtherFeature::class);
    }
    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        BoqEmeLaborRate::creating(function ($model) {
            $model->prepared_by = auth()->id();
        });
    }

    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
