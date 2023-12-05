<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name','head_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'head_id')->withDefault();
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class, 'team_id');
    }

}
