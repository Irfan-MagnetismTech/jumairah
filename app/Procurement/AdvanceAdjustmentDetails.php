<?php

namespace App\Procurement;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Accounts\Account;

class AdvanceAdjustmentDetails extends Model
{
    use HasFactory;
    protected $fillable=['account_id','iou_id','description','remarks','amount','attachment','advanced_adjustment_id'];

    public function advanceadjustment(){
        return $this->belongsTo(AdvanceAdjustment::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function iou()
    {
        return $this->belongsTo(Iou::class);
    }


}
