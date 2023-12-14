<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;

class BdPriorityLandRequest extends FormRequest
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
            'applied_date'                  => 'required|date|date_format:Y-m-d',
            'estimated_total_cost'          => 'required',
            'estimated_total_sales_value'   => 'required',
            'expected_total_profit'         => 'required',
            'bd_lead_generation_details_id' => 'required',
            'estimated_cost'                => 'required',
            'estimated_sales_value'         => 'required',
            'expected_profit'               => 'required'
        ];
    }
}
