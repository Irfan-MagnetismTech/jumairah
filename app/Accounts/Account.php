<?php

namespace App\Accounts;

use App\CogsGroup;
use App\LedgerEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $account_type;

    public function accountable()
    {
        return $this->morphTo();
    }

    public function balanceIncome()
    {
        return $this->belongsTo(BalanceAndIncomeLine::class, 'balance_and_income_line_id', 'id');
    }

    public function ledgers()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function openingBalance()
    {
        return $this->hasMany(AccountsOpeningBalance::class);
    }

    public function cogsGroup()
    {
        return $this->belongsTo(CogsGroup::class)->withDefault();
    }
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_account_id', 'id')->withDefault();
    }

    public function accountChilds()
    {
        return $this->hasMany(Account::class, 'parent_account_id');
    }

    //    public function getAccountTypeAttribute($input)
    //    {
    //        if ($input == '1'){
    //            $account_type  =  'Asset';
    //        } elseif ($input == '2'){
    //            $account_type  =  'Liability';
    //        } elseif ($input == '3'){
    //            $account_type  =  'Equity';
    //        } elseif ($input == '4'){
    //            $account_type  =  'Revenue';
    //        } elseif ($input == '5'){
    //            $account_type  =  'Expense';
    //        }
    //        return $account_type ;
    //    }

    public function previousYearLedger()
    {
        $year = !empty(Session::get('request_year')) ? Session::get('request_year') : now()->year;
        // dd($year);
        return $this->hasMany(LedgerEntry::class)
            ->whereHas('transaction', function ($q) use ($year) {
                $q->where('transaction_date', '<', "$year-01-01");
            });
    }

    public function currentYearLedger()
    {
        $year = !empty(Session::get('request_year')) ? Session::get('request_year') : now()->year;
        return $this->hasMany(LedgerEntry::class)
            ->whereHas('transaction', function ($q) use ($year) {
                $q->whereYear('transaction_date', '=', $year);
            });
    }

    public function getCurrentYearTotalDebitAttribute()
    {
        return $this->currentYearLedger()->sum('dr_amount');
    }

    public function getCurrentYearTotalCreditAttribute()
    {
        return $this->currentYearLedger()->sum('cr_amount');
    }

    public function getPreviousYearTotalDebitAttribute()
    {
        return $this->previousYearLedger()->sum('dr_amount');
    }

    public function getPreviousYearTotalCreditAttribute()
    {
        return $this->previousYearLedger()->sum('cr_amount');
    }

    /*public function getCurrentBalanceAttribute()
    {
        $dr_amount = $this->ledgers()->sum('dr_amount');
        $cr_amount = $this->ledgers()->sum('cr_amount');
        return $dr_amount - $cr_amount;
    }

    public function getDebitBalanceAttribute()
    {
        $dr_amount = $this->ledgers()->sum('dr_amount');
        $cr_amount = $this->ledgers()->sum('cr_amount');
        return $dr_amount - $cr_amount;
        // return $this->ledgers()->sum('dr_amount');
    }

    public function getCreditBalanceAttribute()
    {
        $dr_amount = $this->ledgers()->sum('dr_amount');
        $cr_amount = $this->ledgers()->sum('cr_amount');
        return $cr_amount - $dr_amount ;

        // return  $this->ledgers()->sum('cr_amount');
    }

    public function getTotalDebitAttribute()
    {
        return $this->ledgers()->sum('dr_amount');
    }

    public function getTotalCreditAttribute()
    {
        return $this->ledgers()->sum('cr_amount');
    }*/
}
