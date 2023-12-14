<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdPriorityLandDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bd_lead_generation_details_id',
        'category',
        'margin',
        'cash_benefit',
        'type',
        'status',
        'expected_date', 
        'estimated_cost', 
        'estimated_sales_value', 
        'expected_profit'
    ];

    public function BdLeadGenerationDetail()
    {
        return $this->belongsTo(BdLeadGenerationDetails::class, 'bd_lead_generation_details_id', 'id');
    }

}
