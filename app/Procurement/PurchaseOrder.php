<?php

namespace App\Procurement;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Procurement\Cs;
use App\Approval\Approval;
use App\Procurement\Supplier;
use App\Procurement\CsSupplier;
use App\Procurement\Requisition;
use function PHPUnit\Framework\isNull;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\PurchaseOrderDetail;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['date', 'mpr_id', 'mpr_no', 'po_no', 'cs_id', 'supplier_id', 'final_total', 'carrying_charge', 'labour_charge', 'discount', 'source_tax', 'source_vat', 'carrying', 'remarks', 'applied_by', 'receiver_contact', 'receiver_name'];

    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id', 'id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }

    public function csSupplierForMRR()
    {
        return $this->belongsTo(Cs::class, 'cs_id', 'id')->withDefault();
    }

    public function cssupplier()
    {
        return $this->belongsTo(CsSupplier::class, 'supplier_id', 'supplier_id')->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id')->withDefault();
    }

    public function cs()
    {
        return $this->belongsTo(Cs::class)->withDefault();
    }

    public function mpr()
    {
        return $this->belongsTo(Requisition::class, 'mpr_no')->withDefault();
    }

    public function material_receive()
    {
        return $this->hasMany(MaterialReceive::class, 'po_no', 'po_no');
    }
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }
    protected static function boot()
    {
        parent::boot();
        PurchaseOrder::creating(function ($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
