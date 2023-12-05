<?php

namespace App\Sells;

use App\Project;
use App\ProjectType;
use App\SalesCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','type','type_composite_key','floor','name','face','owner','apartment_size',
        'apartment_rate','apartment_value','parking_no','parking_rate','parking_price','utility_no','utility_rate',
        'utility_fees','reserve_no','reserve_rate','reserve_fund','others', 'total_value'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }

    public function sell()
    {
        return $this->hasOne(Sell::class, 'apartment_id');
    }

    public function leads()
    {
        return $this->hasMany(Leadgeneration::class, 'apartment_id');
    }

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_composite_key', 'composite_key')->withDefault();
    }

    public function salesCollections()
    {
        return $this->hasManyThrough(SalesCollection::class, Sell::class);
    }
}
