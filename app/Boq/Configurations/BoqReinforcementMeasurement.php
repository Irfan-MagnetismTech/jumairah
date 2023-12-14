<?php

namespace App\Boq\Configurations;

use App\Procurement\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqReinforcementMeasurement extends Model
{
    use HasFactory;

    protected $fillable = ['dia', 'weight', 'unit_id'];

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
