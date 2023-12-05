<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderScheduleLine extends Model
{
    use HasFactory;
    protected $fillable = ['workorder_schedule_id', 'work_status', 'payment_ratio'];
}
