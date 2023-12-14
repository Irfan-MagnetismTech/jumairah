<?php

namespace App\Boq\Configurations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BoqFloorType extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'has_buildup_area', 'serial_no'];

    /**
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(BoqFloorType::class, 'parent_id', 'id')->withDefault();
    }

    /**
     * @return mixed
     */
    public function boqFloors()
    {
        return $this->hasMany(BoqFloor::class, 'type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boqWorks(): BelongsToMany
    {
        return $this->belongsToMany(BoqWork::class);
    }


//    public function boqFilteredWorks(): BelongsToMany
//    {
//        return $this->belongsToMany(BoqWork::class)
//            ->where('floor_type', request('floor_type'))
//            ->where('calculation_type', request('calculation_type'));
//    }


    public function boqFloorTypeWorks(): HasMany
    {
        return $this->hasMany(BoqFloorTypeBoqWork::class, 'boq_floor_type_id', 'id');
    }

}
