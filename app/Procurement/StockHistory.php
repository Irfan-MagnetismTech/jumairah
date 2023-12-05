<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CostCenter;
use App\Procurement\Materialmovement;
use App\Procurement\MovementIn;

class StockHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'cost_center_id', 
        'material_receive_report_id',
        'store_issue_id', 'material_id',
        'previous_stock','quantity',
        'present_stock',
        'average_cost',
        'after_discount_po',
        'stockable_id',
        'stockable_type',
        'date'
    ];

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id','id');
    }

    public function materialReceived() //wastage function; dom't use it
    {
        return $this->belongsTo(Materialreceived::class,'material_receive_report_id');
    }

    public function MaterialReceive()
    {
        return $this->belongsTo(MaterialReceive::class,'material_receive_report_id');
    }

    public function storeIssue()
    {
        return $this->belongsTo(Storeissue::class,'store_issue_id');
    }
    public function movementin()
    {
        return $this->belongsTo(MovementIn::class,'stockable_id');
    }
    public function movementout()
    {
        return $this->belongsTo(Materialmovement::class,'stockable_id');
    }
}
