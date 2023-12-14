<?php

namespace Modules\HR\Entities;

use Modules\HR\Entities\Country;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id')->withDefault();
    }
}
