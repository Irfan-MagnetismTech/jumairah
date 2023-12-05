<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IouReportProjectWise extends Model
{
    use HasFactory;
    protected $table = 'iou_report_project_wises';
    protected $fillable = ['cost_center_id', 'iou_date', 'project_wise_iou'];
}
