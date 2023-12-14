<?php

namespace App\Procurement;

use App\User;
use Carbon\Carbon;
use App\CostCenter;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IcmdLaborBudget extends Model
{
    use HasFactory;

    protected $fillable = ['date','cost_center_id','month','total_amount','applied_by'];


    protected $casts = [
        'date' => 'datetime',
    ];

    public function icmdlaborbudgetdetails(){
        return $this->hasMany(IcmdLaborBudgetDetail::class);
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id')->withDefault();
    }


     /**
     * @param $input
     */
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();
        IcmdLaborBudget::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
