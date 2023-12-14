<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use App\CostCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAllocateDetail extends Model
{
    use HasFactory;

    protected $fillable = ['salary_allocate_id','cost_center_id','construction_head_office','icmd','architecture','supply_chain', 'construction_project',
        'contractual_salary','total_salary'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class)->withDefault();
    }

    protected $casts = [
        'construction_head_office'  => CommaToFloat::class,
        'icmd'                      => CommaToFloat::class,
        'architecture'              => CommaToFloat::class,
        'supply_chain'              => CommaToFloat::class,
        'construction_project'      => CommaToFloat::class,
        'contractual_salary'        => CommaToFloat::class,
        'total_salary'              => CommaToFloat::class,
    ];
}
