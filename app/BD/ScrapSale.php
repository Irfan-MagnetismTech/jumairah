<?php

namespace App\BD;

use App\Transaction;
use App\User;
use App\CostCenter;
use App\Approval\Approval;
use App\Procurement\Supplier;
use Illuminate\Support\Carbon;
use App\Procurement\StockHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapSale extends Model
{
    use HasFactory;
    protected $fillable = ['gate_pass', 'scrap_cs_id', 'cost_center_id','sgs','applied_date','supplier_id','grand_total','applied_by'];

    public function scrapSaleDetail(){
        return $this->hasMany(ScrapSaleDetail::class,'scrap_sale_id');
    }

    public function getAppliedDateAttribute($input)
    {
        $applied_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $applied_date;
    }

    public function setAppliedDateAttribute($input)
    {
        $this->attributes['applied_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class,'transactionable')->withDefault();
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,);
    }

    public function scrapCs()
    {
        return $this->belongsTo(ScrapCs::class,);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,);
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function appliedBy(){
        return $this->belongsTo(User::class, 'applied_by');
    }

    public function stocks()
    {
        return $this->morphMany(StockHistory::class,'stockable');
    }
}
