<?php

namespace App\Accounts;

use App\Casts\CommaToFloat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;


Relation::morphMap([
    'Bank' => BankAccount::class,
    'Inter Company' => InterCompany::class,
]);

class Loan extends Model{

    use HasFactory;
    protected $fillable = ['name','loanable_type','loanable_id','loan_type','loan_number','total_sanctioned','sanctioned_limit','opening_date',
                            'start_date','maturity_date', 'interest_rate','installment_size','total_installment','sanctioned_limit',
                            'loan_purpose','description','project_id','emi_date','emi_amount'];

    public function loanReceives()
    {
        return $this->hasMany(LoanReceipt::class);
    }

    public function account()
    {
        return $this->morphOne(Account::class,'accountable')->withDefault();
    }

    public function loanable()
    {
        return $this->morphTo();
    }

    public function setOpeningDateAttribute($input){
        $this->attributes['opening_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getOpeningDateAttribute($input){
        $opening_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $opening_date;
    }

    public function setEmiDateAttribute($input){
        $this->attributes['emi_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getEmiDateAttribute($input){
        $emi_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $emi_date;
    }

    public function setStartDateAttribute($input){
        $this->attributes['start_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getStartDateAttribute($input){
        $start_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $start_date;
    }

    public function setMaturityDateAttribute($input){
        $this->attributes['maturity_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getMaturityDateAttribute($input){
        $maturity_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $maturity_date;
    }

    protected $casts = [
        'sanctioned_limit'  => CommaToFloat::class,
        'total_sanctioned'   => CommaToFloat::class,
    ];
}
