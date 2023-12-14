<?php

namespace App\Procurement;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Approval\Approval;
use App\CostCenter;
use App\Procurement\Requisition;
use App\Procurement\MaterialReceive;
use App\Procurement\GeneralBillDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

    class GeneralBill extends Model
{
    use HasFactory;

    protected $fillable=['date', 'user_id', 'mrr_id', 'mpr_id', 'total_amount', 'cost_center_id' ];

    public function project()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function mrr()
    {
        return $this->belongsTo(MaterialReceive::class,'mrr_id','id')->withDefault();
    }

    public function mpr()
    {
        return $this->belongsTo(Requisition::class, 'mpr_id', 'id')->withDefault();
    }

    public function generalbilldetails(){
        return $this->hasMany(GeneralBillDetails::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }
}
