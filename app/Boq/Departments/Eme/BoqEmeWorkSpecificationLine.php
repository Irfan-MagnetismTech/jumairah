<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqEmeWorkSpecificationLine extends Model
{
    use HasFactory;
    protected $fillable = ['boq_eme_work_specification_id','title','value'];
}
