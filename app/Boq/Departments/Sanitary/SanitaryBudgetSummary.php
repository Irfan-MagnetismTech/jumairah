<?php

namespace App\Boq\Departments\Sanitary;

use App\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryBudgetSummary extends Model
{
    use HasFactory;

    protected $fillable =['project_id','rate_per_unit','total_amount','user_id','type'];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id')->withDefault();
    }
}
