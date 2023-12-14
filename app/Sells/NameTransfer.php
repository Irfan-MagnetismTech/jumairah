<?php

namespace App\Sells;

use App\Accounts\Account;
use App\Approval\Approval;
use App\Casts\CommaToFloat;
use App\SellsClient;
use App\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NameTransfer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['sale_id','tf_percentage','transfer_fee','discount','net_pay','user_id','attachment','details'];

    public function saleClients()
    {
        return $this->hasMany(SellsClient::class)->whereNotNull('name_transfer_id');
    }

    public function sellClient()
    {
        return $this->hasOne(SellsClient::class, 'name_transfer_id')->orderBy('stage','desc')
            ->orderBy('id')->withDefault();
    }

    public function sale()
    {
        return $this->belongsTo(Sell::class)->withDefault('');
    }

    public function account()
    {
        return $this->morphOne(Account::class,'accountable');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }


    protected $casts = [
        'transfer_fee'   => CommaToFloat::class,
        'discount'   => CommaToFloat::class,
        'net_pay'   => CommaToFloat::class,
    ];
}
