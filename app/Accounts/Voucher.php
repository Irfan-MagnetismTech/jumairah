<?php

namespace App\Accounts;

use App\LedgerEntry;
use App\VoucherDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable=['date','section_id','voucher_type','remarks'];

    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    
    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    
}
