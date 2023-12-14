<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;

class BdFeasibilityEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_id'                   => 'required', 
            'total_payment'                 => 'required',
            'rfpl_ratio'                    => 'required',
            'registration_cost'             => 'required',
            'adjacent_road_width'           => 'required',
            'parking_area_per_car'          => 'required',
            'building_front_length'         => 'required',
            'fire_stair_area'               => 'required',
            // 'parking_number'                => 'required',
            'construction_life_cycle'       => 'required',
            'parking_sales_revenue'         => 'required',
            // 'semi_basement_floor_area'      => 'required',
            // 'ground_floor_area'             => 'required',
            'apertment_number'              => 'required',
            'floor_area_far_free'           => 'required'
        ];
    }
}
