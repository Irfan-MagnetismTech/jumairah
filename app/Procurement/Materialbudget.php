<?php

namespace App\Procurement;

use App\Project;
use App\Procurement\NestedMaterial;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialBudget extends Model
{
    use HasFactory; 
    protected $fillable = ['project_id', 'floor_id', 'material_id', 'quantity', 'remarks'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    

    public function setEntryDateAttribute($input)
    {
        $this->attributes['entry_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getEntryDateAttribute($input)
    {
        $entry_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $entry_date;
    }

    

}
