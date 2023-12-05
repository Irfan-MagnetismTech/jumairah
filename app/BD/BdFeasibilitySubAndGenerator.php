<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasibilitySubAndGenerator extends Model
{
    use HasFactory;
    protected $fillable = ['bd_leadgeneration_id', 'kva', 'generator_rate', 'sub_station_rate', 'remarks'];
}
