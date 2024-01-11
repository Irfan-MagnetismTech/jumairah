<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmeLaborHead extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id'
    ];
}
