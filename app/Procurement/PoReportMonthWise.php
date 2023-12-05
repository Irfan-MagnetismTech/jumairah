<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Parent_;

class PoReportMonthWise extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'month_wise_po'
    ];

    // public function setDateAttribute($value)
    // {
    //     $this->attributes['date'] = substr( date_format(date_create($value),"m-y"), 0 ) ;
    // }
}
 