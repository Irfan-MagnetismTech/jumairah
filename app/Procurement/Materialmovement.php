<?php

namespace App\Procurement;

use App\Approval\Approval;
use App\Procurement\Materialmovementdetail ;
use App\Procurement\StockHistory ;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Materialmovement extends Model
{
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['transfer_date','mto_no','entry_by'];

    public function movementdetails(){
        return $this->hasMany(Materialmovementdetail::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function stocks()
    {
        return $this->morphMany(StockHistory::class,'stockable');
    }

    public function entryBy(){
        return $this->belongsTo(User::class, 'entry_by')->withDefault();
    }

    public function setTransferDateAttribute($input)
    {
        !empty($input) ? $this->attributes['transfer_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getTransferDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

}
