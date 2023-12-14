<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdPriorityLand extends Model
{
    use HasFactory;
    protected $fillable = ['applied_date','year','month','estimated_total_cost','estimated_total_sales_value','expected_total_profit','entry_by'];

    public function BdPriorityLandDetails(){
        return $this->hasMany(BdPriorityLandDetail::class, 'bd_priority_land_id', 'id');
    }
}
