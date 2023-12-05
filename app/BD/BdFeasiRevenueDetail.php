<?php

namespace App\BD;

use App\BD\BdFeasiRevenue;
use App\Boq\Configurations\BoqFloor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiRevenueDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'revenue_id',
        'floor_id',
        'floor_sft',
        'rate',
        'total'
    ];

    public function BoqFloor()
    {
        return $this->belongsTo(BoqFloor::class, 'floor_id', 'id');
    }

    public function BdFeasiRevenue()
    {
        return $this->belongsTo(BdFeasiRevenue::class, 'revenue_id');
    }
}
