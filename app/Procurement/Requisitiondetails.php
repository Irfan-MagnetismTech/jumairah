<?php

namespace App\Procurement;

use App\Boq\Configurations\BoqFloor;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\Requisition;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requisitiondetails extends Model
{
    protected $fillable = ['requisition_id', 'floor_id', 'material_id','quantity','required_date','project_id'];

    public function requisition() {
        return $this->belongsTo(Requisition::class)->withDefault();
    }

    public function parent()
    {
    	return $this->belongsTo(NestedMaterial::class, 'parent_id','id')->withDefault();
    }

    public function nestedMaterial(){
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function boqFloor(): BelongsTo
    {
        return $this->belongsTo(BoqFloor::class, 'floor_id', 'id');
    }

    public function boqFloors()
    {
        return $this->hasManyThrough( BoqFloorProject::class,BoqFloor::class,'id','floor_id','floor_id','id');
    }

    public function getRequiredDateAttribute($input)
    {
        $required_date= !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $required_date;
    }
    public function setRequiredDateAttribute($input)
    {
        $this->attributes['required_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

}
