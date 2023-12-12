<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bonus extends Model
{
    protected $guarded = [];

    function bonusSettings(): HasMany
    {
        return $this->hasMany(BonusSetting::class);
    }
}
