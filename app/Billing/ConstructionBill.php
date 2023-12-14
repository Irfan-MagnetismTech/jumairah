<?php

namespace App\Billing;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Transaction;
use App\Approval\Approval;
use App\Procurement\Supplier;
use Illuminate\Support\Collection;
use App\Construction\ConsLaborBudget;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Boq\Departments\Eme\BoqEmeWorkOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConstructionBill extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = [
        'account_id', 'bill_received_date', 'year', 'percentage', 'month', 'week', 'title', 'work_type', 'project_id',
        'supplier_id', 'bill_no', 'reference_no', 'bill_amount', 'remarks', 'prepared_by', 'status', 'user_id', 'is_saved', 'adjusted_amount', 'cost_center_id', 'workorder_id', 'workorder_rate_id', 'due_payable', 'type', 'boq_eme_work_order_id'
    ];

    //    public function getDateAttribute($input)
    //    {
    //        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    //    }
    public function getBillReceivedDateAttribute($input)
    {
        return  !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable')->withDefault();
    }
    /**
     * @param $input
     */
    public function setBillReceivedDateAttribute($input)
    {
        !empty($input) ? $this->attributes['bill_received_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    //    public function setDateAttribute($input)
    //    {
    //        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    //    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by', 'id');
    }

    public function workorderRates()
    {
        return $this->belongsTo(WorkorderRate::class, 'workorder_rate_id');
    }

    public function workorder()
    {
        return $this->belongsTo(Workorder::class, 'workorder_id');
    }

    public function emeWorkorder()
    {
        return $this->belongsTo(BoqEmeWorkOrder::class, 'boq_eme_work_order_id');
    }

    public function lines()
    {
        return $this->hasMany(ConstructionBillLine::class, 'construction_bill_id');
    }
    public function getGroupedLinesAttribute()
    {
        return $this->lines->groupBy('billing_title_id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }



    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by')->withDefault();
    }
}
