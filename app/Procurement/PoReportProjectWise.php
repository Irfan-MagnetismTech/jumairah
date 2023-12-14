<?php

namespace App\Procurement;

use App\CostCenter;
use App\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoReportProjectWise extends Model
{
    use HasFactory; 

    protected $fillable = ['cost_center_id', 'po_date', 'project_wise_po'];

    public function project()
    {
        return $this->belongsTo( Project::class, 'project_id', 'id' );
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id');
    }
}
