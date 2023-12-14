<?php

namespace App\Boq\Configurations;

use App\Boq\Departments\Civil\BoqCivilBudget;
use App\Boq\Projects\BoqFloorProject;
use App\Procurement\Materialreceiveddetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kalnoy\Nestedset\NodeTrait;

class BoqFloor extends Model
{
    use HasFactory,NodeTrait;

    protected $fillable = ['name', 'type_id','parent_id'];

    public function floor_type(): HasOne
    {
        return $this->hasOne(BoqFloorType::class, 'id', 'type_id')
            ->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(BoqFloor::class, 'parent_id','id')->withDefault();
    }

    public function boqCivilBudgets()
    {
        return $this->belongsTo(BoqCivilBudget::class, 'boq_floor_id', 'boq_floor_project_id');
    }

    public function boqFloorProjects()
    {
        return $this->belongsTo(BoqFloorProject::class, 'id', 'floor_id');
    }

    public function boqFloorProject(): HasMany
    {
        return $this->hasMany(BoqFloorProject::class, 'floor_id', 'id');
    }

    public function materialReceiveDetails(){
        return $this->hasMany(Materialreceiveddetail::class, 'floor_id');
    }

}
