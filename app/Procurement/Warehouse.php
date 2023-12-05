<?php

namespace App\Procurement;

use App\User;
use App\Employee;
use App\Approval\Approval;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable=['name', 'location', 'contact_person_id','number','prepared_by'];

    public function users()
    {
        return $this->belongsTo(User::class,'contact_person_id');
    }

    public function WarehouseDetail()
    {
        return $this->hasOne(WarehouseDetail::class, 'warehouse_id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }
    
    public function appliedBy(){
        return $this->belongsTo(User::class, 'prepared_by')->withDefault();
    }
}
