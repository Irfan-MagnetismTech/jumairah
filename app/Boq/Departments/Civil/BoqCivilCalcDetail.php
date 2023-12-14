<?php

namespace App\Boq\Departments\Civil;

use App\Boq\Configurations\BoqReinforcementMeasurement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoqCivilCalcDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'boq_civil_calc_id',
        'boq_civil_calc_group_id',
        'sub_location_name',
        'boq_reinforcement_measurement_id',
        'no_or_dia',
        'length',
        'breadth_or_member',
        'height_or_bar',
        'total',
        'no_or_dia_fx',
        'length_fx',
        'breadth_or_member_fx',
        'height_or_bar_fx',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boqCivilCalcGroup(): BelongsTo
    {
        return $this->belongsTo(BoqCivilCalcGroup::class, 'boq_civil_calc_group_id', 'id')
            ->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boqCivilCalc(): BelongsTo
    {
        return $this->belongsTo(BoqCivilCalc::class, 'boq_civil_calc_id', 'id')
            ->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function boqReinforcementMeasurement(): BelongsTo
    {
        return $this->belongsTo(BoqReinforcementMeasurement::class, 'boq_reinforcement_measurement_id', 'id')
            ->withDefault();
    }
}
