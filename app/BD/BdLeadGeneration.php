<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class BdLeadGeneration extends Model
{
    use HasFactory;
    protected $fillable = ['entry_by', 'category', 'land_under', 'lead_stage', 'source_id', 'land_size', 'front_road_size', 'side_road_size', 'land_location',
                            'remarks', 'status', 'survey_report','division_id','district_id','thana_id','surrendered_land','proposed_front_road_size','proposed_front_road_size','project_category','land_status','mouza_id','land_status','basement','storey'];

    public function BdLeadGenerationDetails()
    {
        return $this->hasMany(BdLeadGenerationDetails::class, 'bd_lead_generation_id');
    }

    public function BdLeadGenerationSideRoads()
    {
        return $this->hasMany(BdleadSideroad::class, 'bd_lead_generation_id');
    }

    public function feasibility(){
        return $this->hasOne(BdFeasibilityEntry::class,'location_id');
    }
    public function feesParticular(){
        return $this->hasOne(BdFeasiFessAndCost::class,'location_id');
    }
    public function ctc(){
        return $this->hasOne(BdFeasibilityCtc::class,'location_id');
    }
    public function revenue(){
        return $this->hasOne(BdFeasiRevenue::class,'location_id');
    }
    public function rncPercent(){
        return $this->hasOne(BdFeasRncPercent::class,'bd_lead_generation_id');
    }
    public function rncCalculation(){
        return $this->hasOne(BdFeasiRncCal::class,'bd_lead_generation_id');
    }
    public function finance(){
        return $this->hasOne(BdFeasiFinance::class,'location_id');
    }
    public function projectLayout(){
        return $this->hasOne(ProjectLayout::class,'bd_lead_location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entry_by', 'id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id')->withDefault();
    }

    public function BdleadFollowUp(){
        return $this->belongsTo(BdleadFollowUp::class, 'bd_lead_generation_id', 'id')->withDefault();
    }
    public function BdLeadGenerationPictures()
    {
        return $this->hasMany(BdLeadGenerationPicture::class, 'bd_lead_generation_id', 'id');
    }

    public function BdFeasibilityFar()
    {
        return $this->hasMany(BdFeasibilityFar::class, 'bd_leadgeneration_id', 'id');
    }

    public function getFullLocationAttribute()
    {
        return $this->land_location . ' - ' . $this->BdLeadGenerationDetails->first()->name;
    }
}
