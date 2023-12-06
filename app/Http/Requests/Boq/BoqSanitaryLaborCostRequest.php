<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;


class BoqSanitaryLaborCostRequest extends FormRequest
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
            'name'          => "required",
            'unit_id'       => "required",
            'rate_per_unit' => "required"
        ];
    }
}