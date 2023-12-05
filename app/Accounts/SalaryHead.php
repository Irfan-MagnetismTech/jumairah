<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryHead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_allocate'];
}
