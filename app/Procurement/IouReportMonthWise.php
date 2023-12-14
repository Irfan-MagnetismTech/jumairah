<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IouReportMonthWise extends Model
{
    use HasFactory;
    protected $table = 'iou_report_month_wises';
    protected $fillable = [
        'date',
        'month_wise_iou'
    ];
}
