<?php

namespace App\Sells;

use App\ApartmentShiftingDetail;
use App\Approval\Approval;
use App\Casts\CommaToFloat;
use App\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentShifting extends Model
{
    use HasFactory;

    protected $fillable=['sale_id','date','old_project_id','old_apartment_id','old_apartment_size','old_apartment_rate','old_utility_no',
        'old_utility_price','old_reserve_no','old_reserve_rate','old_parking_no','old_parking_price','new_project_id','new_apartment_id',
        'new_apartment_size','new_apartment_rate','new_utility_no','new_utility_price','new_reserve_no','new_reserve_rate','new_parking_no',
        'new_parking_price','hand_over_date','attachment','stage','tf_percentage','transfer_fee','discount','old_total_value','new_total_value'];

    public function apartmentShiftingDetails()
    {
        return $this->hasMany(ApartmentShiftingDetail::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sell::class, 'sale_id');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class,'approvable','approvable_type','approvable_id');
    }

    public function oldApartment()
    {
        return $this->belongsTo(Apartment::class,'old_apartment_id')->withDefault();
    }

    public function oldProject (){
        return $this->belongsTo(Project::class,'old_project_id')->withDefault('');
    }

    public function newApartment()
    {
        return $this->belongsTo(Apartment::class,'new_apartment_id')->withDefault();
    }

    public function newProject (){
        return $this->belongsTo(Project::class,'new_project_id')->withDefault('');
    }

    public function setHandOverDateAttribute($input)
    {
        $this->attributes['hand_over_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getHandOverDateAttribute($input)
    {
        $hand_over_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $hand_over_date;
    }

    protected $casts = [
        'transfer_fee'   => CommaToFloat::class,
        'discount'   => CommaToFloat::class,
        'net_pay'   => CommaToFloat::class,
    ];

}
