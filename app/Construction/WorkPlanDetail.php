<?php

namespace App\Construction;

use App\Boq\Configurations\BoqWork;
use App\Procurement\NestedMaterial;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPlanDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'workPlan_id', 
        'work_id', 
        'target', 
        'target_accomplishment', 
        'description', 
        'material_id', 
        'architect_eng_name', 
        'sc_eng_name', 
        'year', 
        'month',  
        'start_date', 
        'finish_date', 
        'delay'];

    public function workPlan()
    {
        return $this->belongsTo(WorkPlan::class, 'workPlan_id', 'id');
    }

    public function boqWorks()
    {
        return $this->belongsTo(BoqWork::class, 'work_id', 'id')->withDefault();
    }

    public function nestedMaterials()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id');
    }


    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }
}
