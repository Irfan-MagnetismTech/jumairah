<?php

namespace App\construction;

use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProgressReportDetails extends Model
{
    use HasFactory;

    protected $fillable = ['cost_center_id', 'date_of_inception', 'date_of_completion'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id');
    }

    public function projectProgressReport(){
        return $this->belongsTo(ProjectProgressReport::class,'cost_center_id')->withDefault();
    }

}
