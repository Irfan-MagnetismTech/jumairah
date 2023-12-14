<?php

namespace App\Boq\Departments\Sanitary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\Unit;

class SanitaryLaborCost extends Model
{
    use HasFactory;
    protected $fillable = ['name','unit_id', 'rate_per_unit'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withDefault();
    }
}
