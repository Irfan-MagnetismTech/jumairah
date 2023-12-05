<?php

namespace App\Boq\Departments\Civil;

use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqCivilMaterialSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'item_head',
        'item_name',
        'unit_id',
        'specification',
        'unit_price',
        'remarks',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
