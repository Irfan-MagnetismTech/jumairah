<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmeUtilityBillDetail extends Model
{
    use HasFactory;
    protected $fillable = ['other_cost_name','other_cost_amount'];

    public function boq_eme_utility_bill(){
        return $this->belongsTo(BoqEmeUtilityBill::class,'boq_eme_utility_bills_id');
    }
}
