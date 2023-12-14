<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdBudget extends Model
{
    use HasFactory;

    protected $fillable = ['applied_date', 'year', 'month', 'progress_total_amount', 'future_total_amount', 'total_amount', 'entry_by'];

    public function BdProgressBudget()
    {
        return $this->hasMany(BdProgressBudget::class, 'bd_budget_id', 'id');
    }

    public function BdFutureBudget()
    {
        return $this->hasMany(BdFutureBudget::class, 'bd_budget_id', 'id');
    }

    public function budgetHead(){
        return $this->hasOne(BudgetHead::class, 'id', 'progress_particulers');
    }

    public function futurebudgetHead(){
        return $this->hasOne(BudgetHead::class, 'id', 'future_particulers');
    }

}
