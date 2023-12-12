<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class ReleasedType extends Model
{
    
    protected $guarded = [];

    public function employeeReleases()
    {
        return $this->hasMany(EmployeeRelease::class, 'released_type_id', 'id');
    }
}
