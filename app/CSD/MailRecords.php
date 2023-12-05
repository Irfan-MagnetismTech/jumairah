<?php

namespace App\CSD;

use App\Project;
use App\Sells\Apartment;
use App\Sells\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_date', 
        'project_id', 
        'address_word_one', 
        'sell_id',
        'letter_subject',
        'address_word_two',
        'letter_body'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'sell_id')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }
    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'sell_id')->withDefault();
    }
}
