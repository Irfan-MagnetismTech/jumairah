<?php

namespace App\BD;

use App\Procurement\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapCsSupplier extends Model
{
    use HasFactory;
     /**
     * @var array
     */
    protected $fillable = [
        'scrap_cs_id',
        'supplier_id',
        'vat_tax',
        'lead_time',
        'payment_type',
        'security_money',
        'is_checked'
    ];

    /**
     * @return mixed
     */
    public function comparativestatement()
    {
        return $this->belongsTo(ScrapCs::class, 'scrap_cs_id');
    }

    /**
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }


}
