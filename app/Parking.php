<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','location','level','total_parking'];

    public function parkingDetails(){
        return $this->hasMany(ParkingDetails::class);
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }

}
