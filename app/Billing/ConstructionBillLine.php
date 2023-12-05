<?php

namespace App\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionBillLine extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'billing_title_id'];

    public function billingTitle()
    {
        return $this->belongsTo(BillingTitle::class, 'billing_title_id');
    }

 
}
