<?php

namespace App\BD;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasibilityCtc extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id',  
        'user_id',
        'grand_total_payable',
        'grand_total_effect'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function BdLeadGeneration(){
        return $this->belongsTo(BdLeadGeneration::class, 'location_id');
    }

    public function BdFeasiCtcDetail(){
        return $this->hasMany(BdFeasiCtcDetail::class, 'feasi_ctc_id', 'id');
    }
    
}
