<?php

namespace App\Boq\Departments\Sanitary;

use App\Boq\Projects\BoqFloorProject;
use App\Procurement\NestedMaterial;
use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWiseMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','floor_id','material_second_id','user_id'];

    public function projectWiseMaterialDetails()
    {
        return $this->hasMany(ProjectWiseMaterialDetails::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    public function floorProject()
    {
        return $this->belongsTo(BoqFloorProject::class,'floor_id','boq_floor_project_id')->withDefault();
    }

    public function materialSecond()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_second_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function NestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_second_id', 'id')->withDefault();
    }
}
