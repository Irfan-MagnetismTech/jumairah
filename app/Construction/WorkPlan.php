<?php

namespace App\Construction;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkPlan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['applied_by', 'project_id','user_id','is_saved'];

    public function workPlanDetails()
    {
        return $this->hasMany(WorkPlanDetail::class, 'workPlan_id', 'id');
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    
    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
    
   

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
    
}
