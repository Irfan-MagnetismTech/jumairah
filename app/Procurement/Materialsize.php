<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materialsize extends Model
{
    use HasFactory;
    protected $fillable = ['material_id','name'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id')->withDefault();
    }
}
