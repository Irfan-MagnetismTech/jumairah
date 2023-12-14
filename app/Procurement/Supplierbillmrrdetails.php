<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbillmrrdetails extends Model
{
    use HasFactory;
    protected $fillable = ['mrr_id'];

    public function supplierbill(){
        return $this->belongsTo(Supplierbill::class,'supplierbill_id');
    }
}
