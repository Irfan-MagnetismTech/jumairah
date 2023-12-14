<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderTerms extends Model
{
    use HasFactory;
    protected $fillable = ['workorder_id', 'general_terms', 'payment_terms'];
}
