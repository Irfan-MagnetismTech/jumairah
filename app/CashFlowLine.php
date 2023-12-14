<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlowLine extends Model
{
    use HasFactory;

    protected $guarded = []; 

    public function parent(){
        return $this->belongsTo(BalanceAndIncomeLine::class, 'parent_id', 'id')->withDefault();
    }

}
