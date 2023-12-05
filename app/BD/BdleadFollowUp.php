<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class BdleadFollowUp extends Model
{
    use HasFactory;
    protected $fillable = ['bd_lead_generation_id', 'followup_date', 'remarks', 'followup_by'];

    public function user(){
        return $this->belongsTo(User::class, 'followup_by', 'id');
    }


}
