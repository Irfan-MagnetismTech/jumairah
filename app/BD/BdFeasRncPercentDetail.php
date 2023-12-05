<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasRncPercentDetail extends Model
{
    use HasFactory;

    protected $fillable = ['type','project_year','cent_1st','cent_2nd','cent_3rd','cent_4th','cent_5th','cent_6th','cent_7th','cent_8th','cent_9th','cent_10th'];

    public function BdFeasRncPercent()
    {
        return $this->belongsTo(BdFeasRncPercent::class);
    }
}

