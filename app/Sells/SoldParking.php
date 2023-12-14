<?php

namespace App\Sells;

use App\ParkingDetails;
use App\Sells\Sell;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldParking extends Model
{
    use HasFactory;
    protected $fillable = ['sell_id','parking_composite','parking_rate'];

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id')->withDefault();
    }

    public function parkingDetails()
    {
        return $this->belongsTo(ParkingDetails::class, 'parking_composite', 'parking_composite')->withDefault();
    }


}
