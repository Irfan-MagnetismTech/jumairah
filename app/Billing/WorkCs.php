<?php

namespace App\Billing;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Approval\Approval;
use App\Billing\WorkCsInvolvment;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkCs extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['title', 'project_id', 'cs_type', 'reference_no', 'effective_date', 'expiry_date', 'remarks', 'description', 'involvement', 'user_id', 'is_saved', 'is_for_all', 'notes'];

    protected $casts = [
        'effective_date' => 'datetime',
        'expiry_date'    => 'datetime',
    ];

    public function getEffectiveDateAttribute($input)
    {
        // return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
        return !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    }

    /**
     * 
     * @param $input
     */
    public function setEffectiveDateAttribute($input)
    {
        !empty($input) ? $this->attributes['effective_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    /**
     * @param $input
     */
    public function getExpiryDateAttribute($input)
    {
        // return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
        return !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    }

    /**
     * @param $input
     */
    public function setExpiryDateAttribute($input)
    {
        !empty($input) ? $this->attributes['expiry_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }


    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function workCsSuppliers()
    {
        return $this->hasMany(WorkCsSupplier::class);
    }

    public function workCsInvolvment()
    {
        return $this->hasMany(WorkCsInvolvment::class, 'work_cs_id', 'id');
    }

    public function selectedWorkCsSuppliers()
    {
        return $this->hasMany(WorkCsSupplier::class)->where('is_checked', 1);
    }
    public function workCsLines()
    {
        return $this->hasMany(WorkCsLine::class);
    }

    /**
     * @return mixed
     */
    public function csSuppliersRates()
    {
        return $this->hasMany(WorkCsSupplierRate::class, 'work_cs_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvable', 'approvable_type', 'approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        WorkCs::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }

    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
