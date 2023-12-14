<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class AdminMonthlyBudget extends Model
{
    use HasFactory;

    protected $fillable = ['date','month','department_id','user_id'];

    public function adminMonthlyBudgetDetails()
    {
        return $this->hasMany(AdminMonthlyBudgetDetail::class, 'budget_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
