<?php

namespace App;

use App\Accounts\Salary;
use App\Accounts\SalaryHead;
use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [ 'unique_key','salary_head_id','gross_salary','fixed_allow','area_bonus','other_refund','less_working_day','payable','pf',
        'other_deduction','lwd_deduction','advance_salary','ait','mobile_bill','canteen','pick_drop','loan_deduction','total_deduction',
        'net_payable','remarks'];

    public function salaryHeads()
    {
        return $this->belongsTo(SalaryHead::class,'salary_head_id','id');
    }

    public function salary()
    {
        return $this->belongsTo(Salary::class)->withDefault();
    }

    protected $casts = [
        'gross_salary' => CommaToFloat::class,
        'fixed_allow' => CommaToFloat::class,
        'area_bonus' => CommaToFloat::class,
        'other_refund' => CommaToFloat::class,
        'payable' => CommaToFloat::class,
        'pf' => CommaToFloat::class,
        'other_deduction' => CommaToFloat::class,
        'lwd_deduction' => CommaToFloat::class,
        'advance_salary' => CommaToFloat::class,
        'ait' => CommaToFloat::class,
        'mobile_bill' => CommaToFloat::class,
        'canteen' => CommaToFloat::class,
        'pick_drop' => CommaToFloat::class,
        'loan_deduction' => CommaToFloat::class,
        'total_deduction' => CommaToFloat::class,
        'net_payable' => CommaToFloat::class,
    ];
}
