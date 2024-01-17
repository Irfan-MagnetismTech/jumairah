<?php

namespace App\Procurement;

use App\User;
use Carbon\Carbon;
use App\CostCenter;
use App\Transaction;
use App\Approval\Approval;
use App\Billing\Workorder;
use App\Procurement\Requisition;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Boq\Departments\Eme\BoqEmeWorkOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Iou extends Model
{
    use HasFactory;
    use LogsActivity;
    use Notifiable;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['iou_no', 'applied_date', 'remarks', 'total_amount', 'applied_by', 'status', 'cost_center_id', 'supplier_id', 'type', 'workorder_id', 'workorder_type', 'po_no', 'boq_eme_work_order_id', 'requisition_id'];

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable')->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id')->withDefault();
    }

    public function ioudetails()
    {
        return $this->hasMany(Ioudetails::class);
    }

    public function setAppliedDateAttribute($input)
    {
        $this->attributes['applied_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getAppliedDateAttribute($input)
    {
        $applied_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $applied_date;
    }


    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }
    public function workOrder()
    {
        return $this->belongsTo(Workorder::class, 'workorder_id');
    }
    public function EmeWorkOrder()
    {
        return $this->belongsTo(BoqEmeWorkOrder::class, 'boq_eme_work_order_id');
    }

    public function mpr()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id', 'id')->withDefault();
    }
}
