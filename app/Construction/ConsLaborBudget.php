<?php

namespace App\Construction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsLaborBudget extends Model
{
    use HasFactory;
    protected $fillable = ['construction_bill_id', 'bill_no', 'week_one', 'week_two', 'week_three', 'week_four','shceduled_date'];

}
