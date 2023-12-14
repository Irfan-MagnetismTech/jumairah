<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderRate extends Model
{
    use HasFactory;
    protected $fillable = ['workorder_id','work_level','work_description','work_quantity','work_unit', 'work_rate'];

}
