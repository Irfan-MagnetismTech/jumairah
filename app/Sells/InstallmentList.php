<?php

namespace App\Sells;

use App\SalesCollection;
use App\SalesCollectionDetails;
use App\Sells\Sell;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallmentList extends Model
{
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['installment_no', 'installment_date', 'installment_amount', 'sell_id', 'installment_composite'];

    /**
     * @return mixed
     */
    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id')->withDefault();
    }

    /**
     * @param $input
     */
    public function setInstallmentDateAttribute($input)
    {
        $this->attributes['installment_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function getInstallmentDateAttribute($input)
    {
        $installment_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;

        return $installment_date;
    }

    /**
     * @return mixed
     */
    public function installmentCollections()
    {
        return $this->hasMany(SalesCollectionDetails::class, 'installment_composite', 'installment_composite')
            ->where('particular', 'Installment')
            // ->OrderByDate()
            ;
    }

//used in sells.show

    /**
     * @return mixed
     */
    public function salesCollections()
    {
        return $this->hasMany(SalesCollection::class, 'sell_id', 'sell_id');
    }

    /**
     * @return mixed
     */
    public function salesCollectionsDetails()
    {
        return $this->salesCollections()->whereHas('salesCollectionDetails');
    }

}
