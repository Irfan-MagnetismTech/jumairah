<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CsSupplier extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'cs_id',
        'supplier_id',
        'collection_way',
        'grade',
        'vat_tax',
        'tax',
        'credit_period',
        'material_availability',
        'delivery_condition',
        'required_time',
        'remarks',
        'is_checked',
        'files'
    ];

    /**
     * @return mixed
     */
    public function comparativestatement()
    {
        return $this->belongsTo(Comparativestatement::class, 'cs_id', 'id');
    }

    /**
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }

    /**
     * @return mixed
     */
    public function csPrices()
    {
        return $this->hasMany(CsPrice::class, 'supplier_id', 'id');
    }

    /**
     * @return mixed
     */
    public function purchaseOrder()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
