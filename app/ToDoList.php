<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    use HasFactory;
    protected $fillable=['user_id', 'task_name','status','creating_date','completion_date'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function setCreatingDateAttribute($input)
    {
        $this->attributes['creating_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getCreatingDateAttribute($input)
    {
        $creating_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $creating_date;
    }

    public function setCompletionDateAttribute($input)
    {
        $this->attributes['completion_date'] =  !empty($input) ?  Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getCompletionDateAttribute($input)
    {
        $completion_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $completion_date;
    }


}
