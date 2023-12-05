<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Projects\BoqFloorProject;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConversionSheet extends Model {
	use HasFactory;

	protected $fillable = [
		'project_id',
		'material_id',
		'boq_floor_id',
		'conversion_date',
		'boq_qty',
		'changed_qty',
		'final_qty',
		'remarks',
		'budget_type',
	];

    public function material(): HasOne
    {
        return $this->hasOne(NestedMaterial::class, 'id', 'material_id')
            ->withDefault();
    }

    public function floorProject(): HasOne
    {
        return $this->hasOne(BoqFloorProject::class, 'boq_floor_project_id', 'boq_floor_id')
            ->withDefault();
    }
}
