<?php

namespace App;

use App\Accounts\HeadThirdLayer;
use App\Accounts\Voucher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherDetail extends Model
{
    use HasFactory;
    
    protected $fillable=['voucher_id','head_id','amount','detail_remarks'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function HeadThirdLayer()
    {
        return $this->belongsTo(HeadThirdLayer::class,'head_id');
    }
}
