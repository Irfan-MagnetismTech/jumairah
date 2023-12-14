<?php

namespace App\Sells;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leadgeneration extends Model
{
    use HasFactory;
    protected $fillable = ['name','country_code','contact','contact_alternate','email','profession','company_name','business_card',
                        'spouse_name','spouse_contact','present_address','permanent_address','nationality','lead_date','lead_stage',
                        'source_type','referral_id','apartment_id','offer_details','attachment','remarks', 'created_by',
                        'country_code_two','country_code_three','contact_alternate_three'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id')->withDefault();
    }

    public function followups()
    {
        return $this->hasMany(Followup::class, 'leadgeneration_id');
    }

    public function lastFollowup()
    {
        return $this->hasOne(Followup::class, 'leadgeneration_id')->latest();
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'lead_id');
    }



    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function setLeadDateAttribute($input)
    {
        $this->attributes['lead_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getLeadDateAttribute($input)
    {
        $lead_Date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $lead_Date;
    }

}
