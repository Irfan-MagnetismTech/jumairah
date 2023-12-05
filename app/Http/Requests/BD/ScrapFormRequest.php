<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScrapFormRequest extends FormRequest
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
            'sgsf_no'        =>  ['required', Rule::unique('scrap_forms', 'sgsf_no')->ignore($this->scrapForm)],
            'cost_center_id'=>  "required",
            'applied_date'  =>  "required|date|date_format:d-m-Y",
            'material_id'   =>  "required|array",
            'quantity'      =>  "required|array",
        ];
    }
}
