<?php

namespace App\Sells;

use App\SellsClient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory;
    use Notifiable;
//    protected $fillable = ['lead_id','father_name','mother_name','dob','marriage_anniversary','tin','picture','auth_name','auth_address','auth_contact','auth_email','auth_picture','client_profile'];

    protected $fillable = ['lead_id','name','company_name','father_name','mother_name','spouse_name','spouse_contact','dob',
                    'marriage_anniversary','nationality','profession','present_address','permanent_address','email','contact',
        'contact_alternate','tin','nid','picture','auth_name','auth_address','auth_contact','auth_email','auth_picture','client_profile'];

    public function routeNotificationForMail($notification): array|string
    {
        // Return email address only...
        return $this->email;
    
        // Return email address and name...
        // return [$this->email => $this->name];
    }

    public function lead()
    {
        return $this->belongsTo(Leadgeneration::class, 'lead_id')->withDefault();
    }

    public function sellsClients()
    {
        return $this->hasMany(SellsClient::class);
    }

    public function clientNominee()
    {
        return $this->hasMany(Nominee::class);
    }

//    public function sell() {
//        return $this->hasOne(Client::class, 'client_id');
//    }

    public function setDobAttribute($input)
    {
        $this->attributes['dob'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getDobAttribute($input)
    {
        $dob = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $dob;
    }

    public function setMarriageAnniversaryAttribute($input)
    {
        $this->attributes['marriage_anniversary'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getMarriageAnniversaryAttribute($input)
    {
        $marriage_anniversary = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $marriage_anniversary;
    }
}
