<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasRncPercent extends Model
{
    use HasFactory;

    protected $fillable = ['bd_lead_generation_id','applied_by'];

    public function BdFeasRncPercentDetail()
    {
        return $this->hasMany(BdFeasRncPercentDetail::class);
    }

    public function BdFeasRPercents()
    {
        return $this->hasMany(BdFeasRncPercentDetail::class)->where('type',1);
    }

    public function BdFeasCPercents()
    {
        return $this->hasMany(BdFeasRncPercentDetail::class)->where('type',0);
    }

    public function BdLeadGeneration()
    {
        return $this->belongsTo(BdLeadGeneration::class, 'bd_lead_generation_id');
    }
}
