<?php

namespace App\Sells;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleactivity extends Model
{
    use HasFactory;
    protected $fillable = ['sell_id','activity_type','date','time_from','time_till','reason','feedback','remarks'];

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id')->withDefault();
    }
}
