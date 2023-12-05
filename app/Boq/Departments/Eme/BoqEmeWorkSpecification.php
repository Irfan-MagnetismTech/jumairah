<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqEmeWorkSpecification extends Model
{
    use HasFactory;
    protected $fillable = ['boq_eme_work_order_id','topic'];

    public function workSpecificationLine()
    {
        return $this->hasMany(BoqEmeWorkSpecificationLine::class);
    }
}
