<?php

namespace App\BD;

use App\CostCenter;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Approval\Approval;

class ScrapForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'sgsf_no',
        'applied_by',
        'status',
        'cost_center_id',
        'applied_date',
        'note'
    ];

    public function scrapFormDetails()
    {
        return $this->hasMany(ScrapFormDetail::class, 'scrap_form_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'applied_by');
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function setAppliedDateAttribute($input)
    {
        !empty($input) ? $this->attributes['applied_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getAppliedDateAttribute($input)
    {
        $transaction_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $transaction_date;
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
}
