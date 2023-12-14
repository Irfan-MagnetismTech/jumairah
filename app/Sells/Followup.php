<?php

namespace App\Sells;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;
    protected $fillable = ['leadgeneration_id','activity_type','date','next_followup_date','time_from','time_till','reason',
                    'feedback','remarks','followup_id','user_id'];

    public function leadgeneration()
    {
        return $this->belongsTo(Leadgeneration::class, 'leadgeneration_id')->withDefault();
    }

    public function followup()
    {
        return $this->hasOne(Followup::class,'followup_id')->withDefault('');
    }


    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setNextFollowupDateAttribute($input)
    {
        $this->attributes['next_followup_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getNextFollowupDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

}
