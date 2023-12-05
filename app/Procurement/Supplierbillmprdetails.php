<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbillmprdetails extends Model
{
    use HasFactory;
    protected $fillable = ['mpr_id'];

    public function supplierbill(){
        return $this->belongsTo(Supplierbill::class,'supplierbill_id');
    }


}
