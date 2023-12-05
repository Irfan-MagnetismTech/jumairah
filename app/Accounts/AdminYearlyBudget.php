<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class AdminYearlyBudget extends Model
{
    use HasFactory;

    protected $fillable = ['date','year','department_id','user_id'];

    public function adminYearlyBudgetDetails()
    {
        return $this->hasMany(AdminYearlyBudgetDetail::class, 'budget_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
