<?php

namespace App\Accounts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = ['name','branch_name','account_type','account_name','account_number','opening_date'];

    public function loans(){
        return $this->morphMany(Loan::class, 'loanable');
    }

    public function account()
    {
        return $this->morphOne(Account::class,'accountable');
    }

    public function setOpeningDateAttribute($input){
        $this->attributes['opening_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getOpeningDateAttribute($input){
        $opening_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $opening_date;
    }

    public function getLoanNumberAttribute()
    {
        return $this->name . ' - ' . $this->account_number;
    }
}
