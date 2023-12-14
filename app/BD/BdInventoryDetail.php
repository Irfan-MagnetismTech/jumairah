<?php

namespace App\BD;

use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdInventoryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost_center_id',
        'land_size',
        'ratio',
        'total_units',
        'lo_units',
        'lo_space',
        'rfpl_units',
        'rfpl_space',
        'margin',
        'rate',
        'parking',
        'utility',
        'other_benefit',
        'remarks',
        'signing_money',
        'inventory_value'
    ];

    public function inventory()
    {
        return $this->belongsTo(BdInventory::class, 'bd_inventory_id', 'id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id', 'id');
    }
}
