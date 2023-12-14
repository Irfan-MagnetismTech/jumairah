<?php

namespace App\construction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectProgressReport extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['applied_by'];

    public function ProjectProgressReportDetails()
    {
        return $this->hasMany(ProjectProgressReportDetails::class, 'pp_report_id', 'id');
    }
}
