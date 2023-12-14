<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['workorder_id', 'rs_title'];

    public function workOrderScheduleLines()
    {
        return $this->hasMany(WorkorderScheduleLine::class, 'workorder_schedule_id', 'id');
    }

}
