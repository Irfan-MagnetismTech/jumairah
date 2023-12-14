<?php

namespace App;

use App\Sells\InstallmentList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCollectionDetails extends Model
{
    use HasFactory;
    protected $fillable = ['sales_collection_id','particular','amount','installment_no', 'applied_days', 
                            'applied_amount', 'installment_composite'];

    public function salesCollection(){
        return $this->belongsTo(SalesCollection::class, 'sales_collection_id');
    }

    public function rebate()
    {
        return $this->hasOne(Rebate::class);
    }

    public function installment()
    {
        return $this->belongsTo(InstallmentList::class, 'installment_composite', 'installment_composite');
    }

    public function scopeOrderByDate($query)
    {
        return $query->orderBy(
            SalesCollection::select('received_date')
            ->whereColumn('salesCollectionDetails.sales_collection_id', 'id')
            ->orderByDesc('received_date')
        );
    }

}
