<?php

namespace App\Accounts;
use App\Config\budgetHead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminYearlyBudgetDetail extends Model
{
    use HasFactory;

    protected $fillable = ['budget_id','budget_head_id','month','remarks','amount'];

    public function budgetHead()
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

    public function adminYearlyBudget()
    {
        return $this->belongsTo(AdminYearlyBudget::class, 'budget_id', 'id');
    }

}
