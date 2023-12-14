<?php

namespace App\Boq\Departments\Civil\Cost;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqCivilConsumableBudget extends Model
{
    use HasFactory;

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'nested_material_id', 'id')
            ->withDefault();
    }
}
