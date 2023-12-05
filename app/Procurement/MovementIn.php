<?php

namespace App\Procurement;

use App\Approval\Approval;
use App\MovementInDetail;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MovementIn extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['materialmovement_id', 'mti_no','receive_date','applied_by'];

    public function movementInDetails(){
        return $this->hasMany(MovementInDetail::class);
    }

    public function materialMovement(){
        return $this->belongsTo(Materialmovement::class,'materialmovement_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function setReceiveDateAttribute($input)
    {
        !empty($input) ? $this->attributes['receive_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getReceiveDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function stocks()
    {
        return $this->morphMany(StockHistory::class,'stockable');
    }
    protected static function boot()
    {
        parent::boot();
        MovementIn::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
