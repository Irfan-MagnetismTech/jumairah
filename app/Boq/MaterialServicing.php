<?php

namespace App\Boq;

use App\Accounts\FixedAsset;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\Materialmovementdetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialServicing extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'fixed_asset_id', 'servicing_status', 'present_status', 'servicing_date', 'comment'];

    public function fixedAsset(){
        return $this->belongsTo(FixedAsset::class, 'fixed_asset_id')->withDefault();
    }

    public function movementdetails(){
        return $this->hasMany(Materialmovementdetail::class,'fixed_asset_id','fixed_asset_id');
    }
}
