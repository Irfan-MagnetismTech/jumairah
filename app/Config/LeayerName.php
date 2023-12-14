<?php

namespace App\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeayerName extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}
