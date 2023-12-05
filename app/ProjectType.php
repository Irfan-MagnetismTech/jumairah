<?php

namespace App;

use App\Sells\Apartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    use HasFactory;
    protected $fillable = ['type_name','size','project_id', 'composite_key'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }
    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'project_id');
    }
    public function typeApartments()
    {
        return $this->hasMany(Apartment::class, 'type_composite_key', 'composite_key');
    }
}
