<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'applied_date',
        'total_signing_money',
        'total_inventory_value'
    ];

    public function BdInventoryDetails()
    {
        return $this->hasMany(BdInventoryDetail::class, 'bd_inventory_id','id');
    }
}
