<?php

namespace App\BD;

use App\Department;
use App\Designation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiCtcDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'fess_ctc_id',     
        'department_id',     
        'designation_id',   
        'employment_nature', 
        'percent_sharing',   
        'number',            
        'gross_salary',      
        'mobile_bill',       
        'providend_fund',    
        'providend_fund_cent',    
        'bonus',             
        'bonus_cent',             
        'Long_term_benefit', 
        'canteen_expense',   
        'earned_encashment', 
        'others',
        'total_payable',
        'total_effect',
        'percent_on_slry'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function BdFeasiCtc(){
        return $this->hasMany(BdFeasibilityCtc::class,'id','feasi_ctc_id');
    }
}
