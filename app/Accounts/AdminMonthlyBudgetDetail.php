<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Config\budgetHead;

class AdminMonthlyBudgetDetail extends Model
{
    use HasFactory;
    protected $fillable = ['budget_id','budget_head_id','week_one', 'week_two', 'week_three', 'week_four','week_five','remarks','amount'];

    public function budgetHead()
    {
        return $this->belongsTo(BudgetHead::class, 'id', 'budget_head_id')->withDefault();
    }

    public function adminMonthlyBudget()
    {
        return $this->belongsTo(AdminMonthlyBudget::class, 'budget_id', 'id');
    }

}
