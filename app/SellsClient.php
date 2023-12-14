<?php

namespace App;

use App\Sells\Client;
use App\Sells\Sell;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellsClient extends Model
{
    use HasFactory;
    protected $fillable = ['sell_id','client_id','stage'];

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withDefault();
    }
}
