<?php

namespace App;

use App\Accounts\Depreciation;
use App\Accounts\FixedAsset;
use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepreciationDetail extends Model
{
    use HasFactory;

    protected $fillable = ['depreciation_id','fixed_asset_id','amount'];

    public function asset()
    {
        return $this->belongsTo(FixedAsset::class,'fixed_asset_id','id')->withDefault();
    }

    public function depreciation()
    {
        return $this->belongsTo(Depreciation::class)->withDefault();
    }

    public function previousMonth()
    {
        return $this->belongsTo(Depreciation::class, 'depreciation_id')
//            ->whereMonth('month','!=', now())
            ;
    }

    public function currentMonth()
    {
        return $this->belongsTo(Depreciation::class, 'depreciation_id')
//            ->whereMonth('month','=', now())
            ;
    }

    protected $casts = [
        'amount' => CommaToFloat::class,
    ];
}
