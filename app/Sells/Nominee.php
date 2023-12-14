<?php

namespace App\Sells;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    use HasFactory;
    protected $fillable = ['client_id','nominee_name','age','address','relation','nominee_picture'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id')->withDefault();
    }
}
