<?php

namespace App\BD;

use App\CostCenter;
use App\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    protected $fillable = [
        'letter_date',
        'cost_center_id',
        'address_word_one',
        'employee_id',
        'letter_subject',
        'address_word_two',
        'letter_body'
    ];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id')->withDefault();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id')->withDefault();
    }
}
