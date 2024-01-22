<?php

namespace App;

use Carbon\Carbon;
use App\Sells\Sell;
use NumberFormatter;
use App\Sells\Apartment;
use App\Accounts\Account;
use Illuminate\Support\Str;
use App\Sells\AccounceApproval;
use App\Sells\SalesCollectionApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesCollection extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['sell_id','received_date','received_amount','payment_mode','source_name','transaction_no','dated', 'remarks', 'attachment'];
//    protected $appends = ['payment_status'];

    public function salesCollectionDetails()
    {
        return $this->hasMany(SalesCollectionDetails::class, 'sales_collection_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function account()
    {
        return $this->morphOne(Account::class,'accountable');
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class)->withDefault();
    }

    public function salesCollectionApprovals()
    {
        return $this->hasMany(SalesCollectionApproval::class, 'salecollection_id');
    }

    public function lastApproval()
    {
        return $this->hasOne(SalesCollectionApproval::class, 'salecollection_id')->orderBy('id', 'desc');
    }

    public function setReceivedDateAttribute($input)
    {
        $this->attributes['received_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getReceivedDateAttribute($input)
    {
        $received_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $received_date;
    }

    public function setDatedAttribute($input)
    {
        $this->attributes['dated'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getDatedAttribute($input)
    {
        $dated = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $dated;
    }

    public function getTotalAmountAttribute($input)
    {
        return $total_amount = $this->salesCollectionDetails()->sum('amount');
    }


    public function getReceivedAmountInwordsAttribute()
    {
        // $f = new \NumberFormatter(locale_get_default(), \NumberFormatter::SPELLOUT);
        $received_amount = $this->received_amount ? ucwords($this->bengaliTk($this->received_amount)) : null;
        return $received_amount;
    }

    public function getPaymentStatusAttribute()
    {
        $status = $this->lastApproval ? $this->lastApproval->approval_status : "Received";
        return $status;
    }

    function bengaliTk($num) {
        $spell = new NumberFormatter(locale_get_default(), NumberFormatter::SPELLOUT);
        $num_in_words = '';

        $units = [
            10000000 => 'Crore',
            100000 => 'Lacs',
            1000 => 'Thousand',
        ];

        foreach ($units as $divisor => $unit) {
            if ($num >= $divisor) {
                $chunk = floor($num / $divisor);
                $num_in_words .= Str::title($spell->format($chunk)) . " $unit ";
                $num %= $divisor;
            }
        }

        if ($num > 0) {
            $num_in_words .= $num;
        }

        return $num_in_words;
    }

}
