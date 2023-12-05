<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcmdLaborBudgetDetail extends Model
{
    use HasFactory;

    protected $fillable = ['description','mason_no','helper_no','mason_rate','helper_rate','amount','remarks'];
}
