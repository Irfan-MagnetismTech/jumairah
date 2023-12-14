<?php

namespace App\Procurement;

use App\Accounts\Account;
use App\Approval\Approval;
use App\Project;
use App\Transaction;
use App\User;
use App\CostCenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\Iou;
use App\Procurement\MaterialReceive;
use Spatie\Activitylog\Traits\LogsActivity;

class AdvanceAdjustment extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable=['date','cost_center_id','grand_total','balance','user_id','iou_id','mrr_id','applied_by'];


    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function iou()
    {
        return $this->belongsTo(Iou::class,'iou_id','id')->withDefault();
    }

    public function advanceadjustmentdetails(){
        return $this->hasMany(AdvanceAdjustmentDetails::class);
    }
    public function appliedBy(){
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

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id')->withDefault();
    }
    public function mrr()
    {
        return $this->belongsTo(MaterialReceive::class,'mrr_id','id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
