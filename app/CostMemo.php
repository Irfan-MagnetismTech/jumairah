<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostMemo extends Model
{
    use HasFactory;
    protected $fillable = ['cost_center_id', 'applied_date'];

    public function costMemoDetails()
    {
        return $this->hasMany(CostMemoDetail::class,'cost_memo_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id');
    }

    public function setAppliedDateAttribute($input){
        $this->attributes['applied_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getAppliedDateAttribute($input){
        $applied_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $applied_date;
    }
}
