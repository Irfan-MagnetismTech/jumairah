<?php

namespace App\Construction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CostCenter;
use Spatie\Activitylog\Traits\LogsActivity;

class TentativeBudget extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['cost_center_id','applied_year','tentative_month','material_cost','labor_cost'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id');
    }
    // public function tentativeBudgetDetails()
    // {
    //     return $this->hasMany(TentativeBudgetDetail::class, 'tentative_budget_id', 'id');
    // }
}
