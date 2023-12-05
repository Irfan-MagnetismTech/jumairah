<?php

namespace App\CSD;

use App\Project;
use App\SalesCollection;
use App\Sells\Apartment;
use App\Sells\Client;
use App\Sells\Sell;
use App\SellsClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Approval\Approval;
use Spatie\Activitylog\Traits\LogsActivity;

class CsdFinalCosting extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = ['project_id', 'apartment_id', 'sell_id', 'status'];

    public function csdFinalCostingDemand()
    {
        return $this->hasMany(CsdFinalCostingDemand::class, 'csd_final_costing_id', 'id');
    }

    public function csdFinalCostingRefund()
    {
        return $this->hasMany(CsdFinalCostingRefund::class, 'csd_final_costing_id', 'id');
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function apartments()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id', 'id');
    }

    public function sellClients()
    {
        return $this->hasMany(SellsClient::class, 'sell_id');
    }

    public function sellClientsInfo()
    {
        return $this->hasMany(SellsClient::class, 'sell_id', 'sell_id');
    }


    public function sellCollections()
    {
        return $this->hasMany(SalesCollection::class, 'sell_id', 'sell_id');
    }
    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
    
}
