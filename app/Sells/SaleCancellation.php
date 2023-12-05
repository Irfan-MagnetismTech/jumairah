<?php

namespace App\Sells;

use App\Accounts\Account;
use App\Approval\Approval;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SaleCancellation extends Model
{
    use HasFactory;
    use LogsActivity;
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['sell_id','paid_amount','service_charge','deducted_amount','refund_amount','attachment','remarks','applied_date','cancelled_by','entry_by','status',
        'approved_date','approved_service_charge','approved_deducted_amount','discount_amount','approved_by'];

    public function sell()
    {
        return $this->belongsTo(Sell::class)->withDefault();
    }

    public function account()
    {
        return $this->morphOne(Account::class,'accountable')->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entry_by', 'id')->withDefault();
    }
    public function approved()
    {
        return $this->belongsTo(User::class, 'entry_by', 'id')->withDefault();
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

    public function setApprovedDateAttribute($input)
    {
        $this->attributes['approved_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getApprovedDateAttribute($input)
    {
        $approved_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $approved_date;
    }

}
