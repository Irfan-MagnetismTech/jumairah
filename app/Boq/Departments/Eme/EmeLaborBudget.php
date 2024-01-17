<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmeLaborBudget extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'boq_eme_rate_id',
        'labor_rate',
        'total_labor_amount',
        'remarks',
        'applied_by'
    ];

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
    public function boqEmeRate(){
        return $this->belongsTo(BoqEmeRate::class)->withDefault();
    }
}
