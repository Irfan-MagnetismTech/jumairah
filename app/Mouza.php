<?php

namespace App;

use App\Thana;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mouza extends Model
{
    protected $fillable = ["thana_id","name"];
    use HasFactory;

    public function thana()
    {
        return $this->belongsTo(Thana::class)->withDefault();
    }
}
