<?php

namespace App\Procurement;

use App\Approval\Approval;
use App\CostCenter;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Requisition extends Model
{
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['mpr_no', 'cost_center_id', 'applied_date', 'note','remarks', 'requisition_by', 'status', 'condition','approval_layer_id'];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }


    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id')->withDefault();
    }

    public function requisitiondetails(){
        return $this->hasMany(Requisitiondetails::class);
    }

    public function iou(){
        return $this->hasMany(Iou::class);
    }
    public function purchase_order()
    {
        return $this->hasMany(PurchaseOrder::class,'mpr_no','id');
    }
    public function requisitionBy(){
        return $this->belongsTo(User::class, 'requisition_by')->withDefault();
    }

    public function getAppliedDateAttribute($input)
    {
        $applied_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $applied_date;
    }

    public function setAppliedDateAttribute($input)
    {
        $this->attributes['applied_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'id', 'mpr_no')->with('cs');
    }



}
