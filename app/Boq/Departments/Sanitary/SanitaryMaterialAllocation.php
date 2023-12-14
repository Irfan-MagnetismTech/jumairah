<?php

namespace App\Boq\Departments\Sanitary;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitaryMaterialAllocation extends Model {
	use HasFactory;

	protected $fillable = ['material_id', 'master', 'master_fc', 'master_lw', 'child', 'child_fc', 'child_lw', 'common',
		'common_fc', 'common_lw', 'small_toilet', 'small_toilet_fc', 'small_toilet_lw', 'kitchen', 'kitchen_fc', 'kitchen_lw',
		'commercial_toilet', 'basin', 'urinal', 'pantry', 'common_toilet', 'total', 'commonArea'];

	public function materials() {
		return $this->belongsTo( NestedMaterial::class, 'material_id', 'id' );
	}
}
