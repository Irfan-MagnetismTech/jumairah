<?php

namespace App\Boq\Departments\Sanitary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWiseLaborCost extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','labor_cost_id','quantity','user_id'];

    public function SanitaryLaborCost()
    {
        return $this->belongsTo(SanitaryLaborCost::class, 'labor_cost_id')->withDefault();
    }

    public function getTotalLabourAmountAttribute()
    {
        return $this->SanitaryLaborCost->rate_per_unit *  $this->quantity;
    }

}
