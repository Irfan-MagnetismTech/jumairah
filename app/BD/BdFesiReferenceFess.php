<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFesiReferenceFess extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'amount'];
}
