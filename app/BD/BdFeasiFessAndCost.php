<?php

namespace App\BD;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BdFeasiFessAndCost extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id',     
        'user_id'
    ];


    public function BdFeasiFessAndCostDetail(){
        return $this->hasMany(BdFeasiFessAndCostDetail::class, 'fess_and_cost_id', 'id');
    }

    public function BdFeasiRefFeesAndCostDetail(){
        return $this->hasMany(BdFeasiFessAndCostDetail::class, 'fess_and_cost_id', 'id')->where('headble_type',BdFesiReferenceFess::class);
    }

    public function BdFeasiGenFeesAndCostDetail(){
        return $this->hasMany(BdFeasiFessAndCostDetail::class, 'fess_and_cost_id', 'id')->where('headble_type',NestedMaterial::class);
    }

    public function BdLeadGeneration(): BelongsTo
    {
        return $this->belongsTo(BdLeadGeneration::class, 'location_id');
    }
}
