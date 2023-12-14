<?php

namespace App\Sells;

use App\Accounts\Account;
use App\SalesCollection;
use App\SalesCollectionDetails;
use App\Sells\InstallmentList;
use App\SellsClient;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model{
    use HasFactory;
    protected $fillable = ['apartment_id','apartment_size','apartment_rate','apartment_value','parking_no','parking_price','utility_no',
        'utility_price','utility_fees','reserve_no','reserve_rate','reserve_fund','others','total_value','booking_money','booking_money_date',
        'downpayment','downpayment_date','installment','sell_by','sell_date','hand_over_date','ho_grace_period','rental_compensation','cancellation_fee',
        'transfer_fee','entry_by'];
//    protected $appends = ['payable_till_today', 'due_till_today'];

    public function account()
    {
        return $this->morphOne(Account::class,'accountable');
    }

    public function saleCancellation()
    {
        return $this->hasOne(SaleCancellation::class,'sell_id');
    }

    public function finalSettlement()
    {
        return $this->hasOne(FinalSettlement::class, 'sale_id');
    }

    public function nameTransfers()
    {
        return $this->hasMany(NameTransfer::class, 'sale_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'sell_by')->withDefault();
    }

    public function entryBy(){
        return $this->belongsTo(User::class,'entry_by')->withDefault();
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id')->withDefault();
    }
    public function soldParking()
    {
        return $this->hasMany(SoldParking::class);
    }

    public function installmentList()
    {
        return $this->hasMany(InstallmentList::class, 'sell_id', 'id');
    }


    public function currentInstallment()
    {
        return $this->hasOne(InstallmentList::class)->whereYear('installment_date', now())
            ->whereMonth('installment_date', now())->withDefault();
    }

    public function maturedInstallments()
    {
        $firstOfMonth = \Carbon\Carbon::now()->firstOfMonth();
        return $this->hasMany(InstallmentList::class, 'sell_id', 'id')->where('installment_date', '<' ,$firstOfMonth);
    }

    public function deuInstallments()
    {
        $currentMonth = Carbon::now()->format('Y-m-d');
        $lastDayofMonth  = date("Y-m-t", strtotime($currentMonth));

        $previousMonth = Carbon::now()->subMonths(2)->format('Y-m-d');

        return $this->hasOne(InstallmentList::class)
//            ->whereDoesntHave('installmentCollections')
            ->whereBetween('installment_date', [$previousMonth,$lastDayofMonth])->withDefault();
    }

    public function nextInstallment()
    {
        return $this->hasOne(InstallmentList::class)
            ->whereDate('installment_date','>=',date('Y-m-d', strtotime(now())));
    }

    public function salesCollections()
    {
        return $this->hasMany(SalesCollection::class, 'sell_id');
    }

    public function currMonthSalesCollections()
    {
        return $this->hasMany(SalesCollection::class, 'sell_id')->whereYear('received_date', now())->whereMonth('received_date', now());
    }


    public function sellClients()
    {
        return $this->hasMany(SellsClient::class, 'sell_id');
//            ->where('stage',$saleClient->stage);
    }
//    public function sellClient()
//    {
//        return $this->hasOne(SellsClient::class, 'sell_id')->oldest()->withDefault();
//    }//means a contact person who will get notification

    public function sellClient()
    {
        return $this->hasOne(SellsClient::class, 'sell_id')->orderBy('stage','desc')
            ->orderBy('id')->withDefault();
    }//means a contact person who will get notification

    public function handover()
    {
        return $this->hasOne(ApartmentHandover::class, 'sell_id');
    }

    public function saleactivities(){
        return $this->hasMany(Saleactivity::class, 'sell_id');
    }

    public function lastCollection()
    {
        return $this->hasOne(SalesCollection::class, 'sell_id')->orderBy('id', 'desc');
    }

    public function salesCollectionDetails()
    {
        return $this->hasManyThrough(SalesCollectionDetails::class, SalesCollection::class);
    }

    public function bookingMoneyCollections()
    {
        return $this->hasManyThrough(SalesCollectionDetails::class, SalesCollection::class)->with('salesCollection')
                            ->where('particular', 'Booking Money');
    }//used in sell.show && sales collection loadBookingMoney

    public function downpaymentCollections()
    {
        return $this->hasManyThrough(SalesCollectionDetails::class, SalesCollection::class)->with('salesCollection')
                            ->where('particular', 'Down Payment');
    }//used in sell.show && sales collection loadDownpayment


    public function setBookingMoneyDateAttribute($input)
    {
        $this->attributes['booking_money_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getBookingMoneyDateAttribute($input)
    {
        $booking_money_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $booking_money_date;
    }

    public function setHandOverDateAttribute($input)
    {
        $this->attributes['hand_over_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getHandOverDateAttribute($input)
    {
        $hand_over_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $hand_over_date;
    }
    public function setDownpaymentDateAttribute($input)
    {
        $this->attributes['downpayment_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getDownpaymentDateAttribute($input)
    {
        $downpayment_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $downpayment_date;
    }
    public function setSellDateAttribute($input)
    {
        $this->attributes['sell_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getSellDateAttribute($input)
    {
        $sell_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $sell_date;
    }

    public function getPayableTillTodayAttribute()
    {
        $payableTillToday = 0;
        $payableTillToday += $this->booking_money_date && Carbon::parse($this->booking_money_date) <= now() ? $this->booking_money : 0;
        $payableTillToday += $this->downpayment_date && Carbon::parse($this->downpayment_date) <= now() ? $this->downpayment : 0;
        $payableTillToday += $this->installmentList()->whereDate('installment_date','<=', now())->get()->sum('installment_amount');

        return $payableTillToday;
    }//payableTillDate (B+D+I) used in projectreport route && Individual collection

    public function getDueTillTodayAttribute()
    {
        $dueTillToday = $this->payableTillToday > $this->salesCollections->sum('received_amount') ?
            $this->payableTillToday - $this->salesCollections->sum('received_amount') : null;
        return $dueTillToday;
//        return $this->payableTillToday;
    }//dueTillToday (B+D+I) used in projectreport route && Individual collection

    public function scopeDateRange($query, $column, $dateType, $fromDate, $tillDate)
    {
        if($dateType === 'custom' && $fromDate && $tillDate){
            return $query->whereBetween($column, [$fromDate, $tillDate]);
        }elseif($dateType === 'monthly'){
            return $query->whereBetween($column, [now()->subDays(30), now()]);
        }elseif($dateType === 'weekly'){
            return $query->whereBetween($column, [now()->subDays(7), now()]);
        }elseif($dateType === 'today'){
            return $query->whereDate($column, now());
        }else{
            return $query->whereDate($column, now());
        }
    }

}
