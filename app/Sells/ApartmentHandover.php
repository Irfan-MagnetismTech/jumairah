<?php

namespace App\Sells;

use App\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ApartmentHandover extends Model
{
    use HasFactory;
    protected $fillable = ['sell_id', 'handover_date','remarks'];

    public function sell()
    {
        return $this->belongsTo(Sell::class)->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function setHandoverDateAttribute($input)
    {
        $this->attributes['handover_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getHandoverDateAttribute($input)
    {
        $handover_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $handover_date;
    }
}
