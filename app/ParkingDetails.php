<?php

namespace App;

use App\Sells\SoldParking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingDetails extends Model
{
    use HasFactory;
    protected $fillable = ['parking_id','parking_name','parking_owner', 'parking_composite'];

    public function parking()
    {
        return $this->belongsTo(Parking::class, 'parking_id')->withDefault();
    }

    public function soldParking()
    {
        return $this->hasOne(SoldParking::class, 'parking_composite', 'parking_composite')->withDefault();
    }

}
