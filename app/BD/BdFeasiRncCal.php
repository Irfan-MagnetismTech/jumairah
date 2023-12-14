<?php

namespace App\BD;

use App\BD\BdFeasiRncCalCost;
use App\BD\BdFeasiRncCalRate;
use App\BD\BdFeasiRncCalSale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiRncCal extends Model
{
    use HasFactory;
    protected $fillable = ['bd_lead_generation_id','project_year'];

    public function BdFeasRncCalCost()
    {
        return $this->hasOne(BdFeasiRncCalCost::class);
    }

    public function BdFeasRncCalRate()
    {
        return $this->hasOne(BdFeasiRncCalRate::class);
    }


    public function BdFeasRncCalSale()
    {
        return $this->hasOne(BdFeasiRncCalSale::class);
    }

    public function BdLeadGeneration()
    {
        return $this->belongsTo(BdLeadGeneration::class, 'bd_lead_generation_id');
    }
}
