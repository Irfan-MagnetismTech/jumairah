<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdLeadGenerationDetails extends Model
{
    use HasFactory;
    protected $fillable = ['bd_lead_generation_id', 'name', 'mobile', 'mail', 'present_address'];

    public function bdLeadGeneration()
    {
        return $this->belongsTo(BdLeadGeneration::class); 
    }

}
