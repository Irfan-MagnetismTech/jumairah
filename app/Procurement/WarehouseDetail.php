<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable=['warehouse_id', 'total_value', 'per_mounth_rent','adjusted_amount', 'advance', 'duration', 'owner_name', 'owner_contact', 'owner_address'];

   
}
