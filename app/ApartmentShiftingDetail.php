<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentShiftingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['parking_composite','parking_rate','sell_id'];
}
