<?php

namespace App\Procurement;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\CostCenter;
use App\Transaction;
use App\Approval\Approval;
use App\Procurement\Requisition;
use function PHPUnit\Framework\isNull;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialReceive extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable =['po_no', 'mrr_no', 'cost_center_id', 'date','remarks','quality','status','iou_id','applied_by','requisition_id'];

    public function materialreceivedetails(){
        return $this->hasMany(Materialreceiveddetail::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function purchaseorderForPo()
    {
        return $this->belongsTo(PurchaseOrder::class,'po_no','po_no')->withDefault();
    }

    public function purchaseorder()
    {
        return $this->belongsTo(PurchaseOrder::class,'po_no','po_no')->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function costCenter()
    {
        return $this->hasMany(CostCenter::class,'id','cost_center_id');
    }

    public function costCenters()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id')->withDefault();
    }

    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id','id')->withDefault();
    }

    public function stockHistory()
    {
        return $this->hasMany(StockHistory::class, 'material_receive_report_id', 'id');
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function iou()
    {
        return $this->belongsTo(Iou::class,'iou_id','id')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();

        MaterialReceive::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function mpr()
    {
        return $this->belongsTo(Requisition::class,'requisition_id')->withDefault();
    }
}
