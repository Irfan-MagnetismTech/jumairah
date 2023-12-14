<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqEmeWorkorderTerm extends Model
{
    use HasFactory;
    protected $fillable = ['boq_eme_work_order_id','general_terms','payment_terms'];
}
