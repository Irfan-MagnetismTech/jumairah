<?php

namespace App;

use App\Sells\Sell;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $fillable = ['team_id','member_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id')->withDefault();
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }



}
