<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingTitle extends Model
{
    use HasFactory;
    protected $fillable= ['name'];
}
