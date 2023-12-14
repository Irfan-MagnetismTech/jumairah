<?php

namespace App\Billing;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Procurement\Iou;
use App\Approval\Approval;
use App\Procurement\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class Workorder extends Model
{
    use HasFactory;

    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['issue_date','work_cs_id','workorder_no','subject','supplier_id','deadline','remarks','prepared_by', 'description', 'involvement','project_id'];

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
        return $this->belongsTo(WorkCs::class)->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id')->withDefault();
    }

    public function workorderRates()
    {
        return $this->hasMany(WorkorderRate::class);
    }

    public function terms()
    {
        return $this->hasOne(WorkorderTerms::class);
    }

    public function workOrderSchedules()
    {
        return $this->hasMany(WorkorderSchedule::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }


    public function appliedBy(){
        return $this->belongsTo(User::class, 'prepared_by')->withDefault();
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
