<?php

namespace App;

use App\Casts\CommaToFloat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationDetail extends Model
{
    use HasFactory;

    protected $fillable = ['allocation_id','cost_center_id','management_fee','division_fee','construction_depreciation', 'architecture_fee',
                            'total_allocation'];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class)->withDefault();
    }

    protected $casts = [
        'cost_center_id'       =>         CommaToFloat::class,
        'management_fee'       =>       CommaToFloat::class,
        'division_fee'      =>          CommaToFloat::class,
        'construction_depreciation'   => CommaToFloat::class,
        'architecture_fee'   =>         CommaToFloat::class,
        'total_allocation'   =>         CommaToFloat::class,
    ];
}
