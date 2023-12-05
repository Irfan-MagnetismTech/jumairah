<?php

namespace App\Procurement;

use App\Approval\Approval;
use App\BillRegister;
use App\CostCenter;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;

class Supplierbill extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected $fillable = ['cost_center_id','purpose', 'register_serial_no', 'bill_no', 'date','applied_by','status', 'carrying_charge', 'labour_charge', 'discount', 'final_total'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id')->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function appliedBy()
    {
        return $this->belongsTo(User::class,'applied_by');
    }

    public function podetails(){
        return $this->hasMany(Supplierbillpodetails::class);
    }
    public function mprdetails(){
        return $this->hasMany(Supplierbillmprdetails::class);
    }

    public function mrrdetails(){
        return $this->hasMany(Supplierbillmrrdetails::class);
    }

    public function billnodetails(){
        return $this->hasMany(Supplierbillnodetails::class);
    }

    public function officebilldetails(){
        return $this->hasMany(Supplierbillofficebilldetails::class);
    }

    public function billRegister()
    {
        return $this->belongsTo(BillRegister::class, 'register_serial_no', 'serial_no')->withDefault();
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

    public function getRequestDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setRequestDateAttribute($input)
    {
        $this->attributes['request_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;

    }
    // public function RequestedSupplier(){
    //     return $this->where('is_requested',1);
    //     // return $this->ScrapcsSuppliers()->where('is_checked',1)->get();
    // }

    public function scopeRequestedSupplier($query)
    {
        return $query->where('is_requested',1);
    }
}
