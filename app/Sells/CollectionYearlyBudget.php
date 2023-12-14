<?php

namespace App\Sells;

use App\CollectionYearlyBudgetDetails;
use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionYearlyBudget extends Model
{
    use HasFactory;

    protected $fillable = ['year','user_id','project_id'];

    public function collectionYearlyBudgetDetails()
    {
        return $this->hasMany(CollectionYearlyBudgetDetails::class, 'yearly_budget_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }
}
