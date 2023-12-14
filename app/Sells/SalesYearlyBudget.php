<?php

namespace App\Sells;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesYearlyBudget extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','year','user_id'];

    public function salesYearlyBudgetDetails()
    {
        return $this->hasMany(SalesYearlyBudgetDetail::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
