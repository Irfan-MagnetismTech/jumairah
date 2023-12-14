<?php

namespace App\Accounts;

use App\DepreciationDetail;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    use HasFactory;

    protected $fillable =['date','month'];

    public function depreciationDetails()
    {
        return $this->hasMany(DepreciationDetail::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

//    public function setMonthAttribute($input)
//    {
//        !empty($input) ? $this->attributes['month'] = Carbon::createFromFormat('Y-m', $input)->format("Y-m-d") : null;
//    }
    public function getMonthAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('M, Y') : null;
        return $date;
    }
}
