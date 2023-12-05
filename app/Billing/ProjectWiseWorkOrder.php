<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWiseWorkOrder extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','project_wise_workorder'];
}
