<?php

namespace App\CSD;

use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class CsdMaterial extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name', 
        'parent_id', 
        '_lft', 
        '_rgt', 
        'unit_id',
        'model'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }

    public function materialRate()
    {
        return $this->hasOne(CsdMaterialRate::class, 'material_id', 'id');
    }

    
    public function childs()
    {
    	return $this->hasMany(CsdMaterial::class, 'parent_id', 'id')->withDefault();
    }

    public function parent()
    {
    	return $this->belongsTo(CsdMaterial::class, 'parent_id','id')->withDefault();
    }
}
