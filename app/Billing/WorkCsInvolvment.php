<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCsInvolvment extends Model
{
    use HasFactory;

    protected $fillable = ['detail', 'work_cs_id'];
}
