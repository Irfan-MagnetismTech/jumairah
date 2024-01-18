<?php

namespace App\Procurement;

use App\Accounts\Account;
use App\CSD\CsdMaterialRate;
use App\Boq\BoqMaterialPrice;
use Kalnoy\Nestedset\NodeTrait;
use App\Boq\Departments\Eme\BoqEmeRate;
use Illuminate\Database\Eloquent\Model;
use App\Boq\Departments\Civil\BoqCivilBudget;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Boq\Configurations\BoqMaterialPriceWastage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Boq\Departments\Sanitary\ProjectWiseMaterial;
use App\Boq\Departments\Sanitary\SanitaryMaterialRate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Boq\Departments\Sanitary\SanitaryMaterialAllocation;

class NestedMaterial extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = ['name', 'parent_id', '_lft', '_rgt', 'unit_id', 'material_status', 'account_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }

    public function account()
    {
        return $this->belongsTo(Account::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(NestedMaterial::class, 'parent_id', 'id')->withDefault();
    }

    public function materialAllocation()
    {
        return $this->hasOne(SanitaryMaterialAllocation::class, 'material_id');
    }
    public function projectWiseMaterialRates()
    {
        return $this->hasMany(ProjectWiseMaterial::class, 'material_id', 'id');
    }
    public function sanitaryMaterialRates()
    {
        return $this->hasMany(SanitaryMaterialRate::class, 'material_id', 'id');
    }


    public function childs()
    {
        return $this->hasMany(NestedMaterial::class, 'parent_id', 'id');
    }

    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    public function getRootNode()
    {
        return $this->isRoot() ? $this : $this->parent->getRootNode();
    }

    public function materialPrice()
    {
        return $this->hasOne(BoqMaterialPrice::class, 'material_id', 'id');
    }

    public function materialReceiveDetails()
    {
        return $this->belongsTo(Materialreceiveddetail::class, 'id', 'material_id');
    }

    public function boqCivilBudget(): HasMany
    {
        return $this->hasMany(BoqCivilBudget::class, 'nested_material_id');
    }

    public function boqSupremeBudgets(): HasMany
    {
        return $this->hasMany(BoqSupremeBudget::class, 'material_id', 'id');
    }

    public function requisitionDetails()
    {
        return $this->hasMany(Requisitiondetails::class, 'material_id');
    }

    public function boqConsumableCosts(): HasMany
    {
        return $this->hasMany(BoqConsumableCost::class, 'nested_material_id', 'id');
    }

    public function scopeNotInPo($query, $mpr_no = null)
    {
        $purchase_order_materials = PurchaseOrderDetail::whereHas('purchaseOrder', function ($query) use ($mpr_no) {
            $query->where('mpr_no', $mpr_no);
        })
            ->get()
            ->pluck('material_id');

        $query->whereHas('requisitionDetails.requisition', function ($query) use ($mpr_no) {
            return $query->where('id', $mpr_no);
        })
            ->whereHas('requisitionDetails', function ($query) use ($purchase_order_materials) {
                return $query->whereNotIn('material_id', $purchase_order_materials);
            });
    }
    public function stockHistory()
    {
        return $this->belongsTo(StockHistory::class, 'material_id', 'id')->withDefault();
    }

    public function BoqEmeRate()
    {
        return $this->belongsTo(BoqEmeRate::class, 'id', 'material_id')->withDefault();
    }

    public function materialPriceWastage(): HasOne
    {
        return $this->hasOne(BoqMaterialPriceWastage::class, 'nested_material_id', 'id')
            ->withDefault();
    }

    public function materialRate()
    {
        return $this->hasOne(CsdMaterialRate::class, 'material_id', 'id');
    }
}
