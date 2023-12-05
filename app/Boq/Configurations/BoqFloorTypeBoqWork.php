<?php

namespace App\Boq\Configurations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqFloorTypeBoqWork extends Model
{
    use HasFactory;
    protected $table = 'boq_floor_type_boq_work';

    protected $fillable = [
        'boq_floor_type_id',
        'boq_work_id',
    ];

    public function boq_floor_type()
    {
        return $this->belongsTo('App\Boq\Configurations\BoqFloorType');
    }

    public function boq_work()
    {
        return $this->belongsTo('App\Boq\Configurations\BoqWork');
    }

}
