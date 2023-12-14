<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdYearlyBudget extends Model
{
    use HasFactory;
    protected $fillable = ['applied_date', 'year', 'progress_total_amount', 'future_total_amount', 'total_amount', 'entry_by'];

    public function BdProgressYearlyBudget()
    {
        return $this->hasMany(BdProgressYearlyBudget::class, 'bd_yearly_budget_id', 'id');
    }

    public function BdFutureYearlyBudget()
    {
        return $this->hasMany(BdFutureYearlyBudget::class, 'bd_yearly_budget_id', 'id');
    }

}
