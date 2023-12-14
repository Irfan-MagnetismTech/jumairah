<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdLeadGenerationPicture extends Model
{
    use HasFactory;

    protected $fillable = ['bd_lead_generation_id', 'picture'];

}
