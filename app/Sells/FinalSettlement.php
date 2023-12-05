<?php

namespace App\Sells;

use App\Casts\CommaToFloat;
use App\Project;
use App\Sells\Client;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalSettlement extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','sale_id','registration_cost','discount','user_id'];

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class,'sale_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    protected $casts = [
        'registration_cost'  => CommaToFloat::class,
        'discount'   => CommaToFloat::class,
    ];
}
