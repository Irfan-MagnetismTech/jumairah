<?php

namespace Modules\HR\Entities;

// use Modules\HR\Entities\Department;
use App\Department;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subsections()
    {
        return $this->hasMany(SubSection::class, 'section_id', 'id');
    }
    public function employees()
    {
        return $this->hasMany(Employee::class, 'section_id', 'id');
    }
}
