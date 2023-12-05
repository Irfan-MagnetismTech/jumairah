<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\Sells\Client;
use App\Sells\Apartment;

class BoqEmeUtilityBill extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','client_id','apartment_id','period','previous_reading','present_reading','electricity_rate','common_electric_amount','total_bill','total_electric_amount_aftervat','due_amount','delay_charge_percent','pfc_charge_percent','demand_charge_percent','vat_tax_percent','meter_no'];

    public function eme_utility_bill_detail(){
        return $this->hasMany(EmeUtilityBillDetail::class,'boq_eme_utility_bills_id','id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id')->withDefault();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withDefault();
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }
}
