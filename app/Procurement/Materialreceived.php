<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materialreceived extends Model
{
    use HasFactory;

    protected $fillable = ['mpr_no'];



    public function materialreceivedetails(){
        return $this->hasMany(Materialreceiveddetail::class);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

}
