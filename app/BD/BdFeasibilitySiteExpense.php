<?php

namespace App\Bd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasibilitySiteExpense extends Model
{
    use HasFactory;
    protected $fillable = ['bd_leadgeneration_id', 'land_area', 'monthly_expense'];
}
