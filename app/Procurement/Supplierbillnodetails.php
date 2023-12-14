<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierbillnodetails extends Model
{
    use HasFactory;
    protected $fillable = ['bill_no','amount',];
    public function supplierbill(){
        return $this->belongsTo(Supplierbill::class,'supplierbill_id');
    }
}
