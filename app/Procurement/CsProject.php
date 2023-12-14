<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Project;
use Spatie\Activitylog\Traits\LogsActivity;

class CsProject extends Model
{
    use HasFactory;

    protected $fillable = ['cs_id','project_id'];

    public function comparativestatement()
    {
        return $this->belongsTo(Cs::class, 'cs_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Project::class, 'project_id')->withDefault();
    }

}
