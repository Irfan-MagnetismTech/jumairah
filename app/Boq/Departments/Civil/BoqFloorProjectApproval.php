<?php

namespace App\Boq\Departments\Civil;

use App\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqFloorProjectApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
