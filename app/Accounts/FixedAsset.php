<?php

namespace App\Accounts;

use Carbon\Carbon;
use App\Transaction;
use App\FixedAssetCost;
use App\Casts\CommaToFloat;
use App\DepreciationDetail;
use App\Procurement\MaterialReceive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedAsset extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['mrr_no','received_date', 'tag','bill_no', 'name', 'department_id', 'life_time', 'location','use_date',
                           'brand', 'model', 'asset_type','serial','price','percentage','account_id','cr_account_id','cost_center_id', 'material_id'];

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function previousTransection()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function account()
    {
        return $this->morphMany(Account::class,'accountable');
    }

    public function depreciationAccount()
    {
        return $this->morphOne(Account::class, 'accountable')->where('balance_and_income_line_id',86);
    }

    public function depreciationDetails()
    {
        return $this->hasMany(DepreciationDetail::class);
    }
    public function fixedAssetCosts()
    {
        return $this->hasMany(FixedAssetCost::class);
    }

    public function previousMonth()
    {
        return $this->hasMany(DepreciationDetail::class)->whereHas('depreciation', function ($query) {
//            $query->whereMonth('month','<', now());
        });
    }

    public function setReceivedDateAttribute($input)
    {
        !empty($input) ? $this->attributes['received_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getReceivedDateAttribute($input)
    {
        $received_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $received_date;
    }
    public function setUseDateAttribute($input)
    {
        !empty($input) ? $this->attributes['use_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getUseDateAttribute($input)
    {
        $use_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $use_date;
    }

    public function materialReceive(){
        return $this->belongsTo(MaterialReceive::class,'mrr_no','mrr_no');
    }
    protected $casts = [
          'price' => CommaToFloat::class
        ];


}
