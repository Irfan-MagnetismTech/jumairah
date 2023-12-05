<?php

namespace App;

use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAssetCost extends Model
{
    use HasFactory;

    protected $fillable = ['fixed_asset_id', 'particular','amount'];

    protected $casts = [
      'amount' => CommaToFloat::class
    ];
}
