<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConversionSheetRequest extends FormRequest
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
            'project_id'         => "required",
            'nested_material_id' => "required",
            'conversion_date'    => "required",
            'boq_floor_id'       => "required|array",
            'boq_floor_id.*'     => "required",
            'previous_quantity'  => "required|array",
            'previous_quantity.*'=> "required",
            'used_quantity'      => "required|array",
            'used_quantity.*'    => "required",
            'revised_quantity'   => "required|array",
            'revised_quantity.*' => "required",
            'budget_type'        => "required",
        ];
    }
}
