<?php

namespace App\Procurement;

use App\Approval\Approval;
use App\CostCenter;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MovementRequisition extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['date',    'delivery_date',    'mtrf_no',    'mpr_no',   'from_costcenter_id', 'to_costcenter_id',   
                         'reason',    'remarks',    'requested_by'];

    public function movementRequisitionDetails(){
        return $this->hasMany(MovementRequisitionDetail::class);
    }

    public function movementDetails(){
        return $this->hasMany(Materialmovementdetail::class, 'movement_requision_id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function fromCostCenter(){
        return $this->belongsTo(CostCenter::class, 'from_costcenter_id');
    }

    public function toCostCenter(){
        return $this->belongsTo(CostCenter::class, 'to_costcenter_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'requested_by');
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

    public function getDeliveryDateAttribute($input)
    {
        $delivery_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $delivery_date;
    }

    public function setDeliveryDateAttribute($input)
    {
        $this->attributes['delivery_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
}
