<?php

namespace App\Procurement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Approval\Approval;
use App\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Cs extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected $fillable = ['reference_no', 'effective_date', 'expiry_date', 'remarks','applied_by'];

    /**
     * @var array
     */
    protected $casts = [
        'effective_date' => 'datetime',
        'expiry_date'    => 'datetime',
    ];

    /**
     * @param $input
     */
    public function getEffectiveDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
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
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
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
    public function csProjects()
    {
        return $this->hasMany(CsProject::class, 'cs_id');
    }

    /**
     * @return mixed
     */
    public function csMaterials()
    {
        return $this->hasMany(CsMaterial::class, 'cs_id');
    }

    /**
     * @return mixed
     */
    public function csSuppliers()
    {
        return $this->hasMany(CsSupplier::class, 'cs_id', 'id');
    }

    /**
     * @return mixed
     */
    public function csMaterialsSuppliers()
    {
        return $this->hasMany(CsMaterialSupplier::class, 'cs_id');
    }

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class, 'cs_id', 'id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        CS::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
}
