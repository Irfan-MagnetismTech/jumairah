<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCsLine extends Model
{
    use HasFactory;
    protected $fillable = ['work_cs_id','work_level','work_description','work_quantity','work_unit']; 
    
}
