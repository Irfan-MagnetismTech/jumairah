<?php

namespace App\BD;

use App\User;
use Carbon\Carbon;
use App\CostCenter;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapCs extends Model
{
    use HasFactory;
    protected $fillable = ['reference_no', 'effective_date', 'expiry_date', 'remarks','cost_center_id','applied_by'];

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
    // public function csProjects()
    // {
    //     return $this->hasMany(ScrapCsProject::class, 'cs_id');
    // }

    /**
     * @return mixed
     */
    public function ScrapcsMaterials()
    {
        return $this->hasMany(ScrapCsMaterial::class, 'scrap_cs_id');
    }

    /**
     * @return mixed
     */
    public function ScrapcsSuppliers()
    {
        return $this->hasMany(ScrapCsSupplier::class, 'scrap_cs_id');
    }

    public function SelectedSupplier(){
        return $this->hasMany(ScrapCsSupplier::class, 'scrap_cs_id')->where('is_checked',1);
        // return $this->ScrapcsSuppliers()->where('is_checked',1)->get();
    }
    /**
     * @return mixed
     */
    public function ScrapcsMaterialsSuppliers()
    {
        return $this->hasMany(ScrapCsMaterialSupplier::class, 'scrap_cs_id');
    }

    // public function purchaseOrder(){
    //     return $this->belongsTo(PurchaseOrder::class, 'cs_id', 'id');
    // }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    protected static function boot()
    {
        parent::boot();

        ScrapCs::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }
   
}
