<?php

namespace App\Boq\Departments\Eme;

use App\User;
use App\Project;
use Carbon\Carbon;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeCs extends Model
{
    use HasFactory;

    protected $fillable = ['reference_no', 'effective_date', 'expiry_date', 'remarks','applied_by','project_id'];

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
    public function csMaterials()
    {
        return $this->hasMany(BoqEmeCsMaterial::class, 'boq_eme_cs_id','id');
    }

    /**
     * @return mixed
     */
    public function csSuppliers()
    {
        return $this->hasMany(BoqEmeCsSupplier::class, 'boq_eme_cs_id', 'id');
    }

    /**
     * @return mixed
     */
    public function csMaterialsSuppliers()
    {
        return $this->hasMany(BoqEmeCsMaterialSupplier::class, 'boq_eme_cs_id','id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
    
    protected static function boot()
    {
        parent::boot();

        BoqEmeCs::creating(function($model) {
            $model->applied_by = auth()->id();
        });
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
