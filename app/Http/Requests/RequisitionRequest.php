<?php

namespace App\Http\Requests;

use App\Rules\CheckUniqueArray;
use App\Rules\RequisitionRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RequisitionRequest extends FormRequest
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
            'mpr_no'        =>  ['required', Rule::unique('requisitions', 'mpr_no')->ignore($this->requisition)],
            'cost_center_id'=>  "required",
            'applied_date'  =>  "required|date|date_format:d-m-Y",
            'quantity'      =>  "required|array",
        ];
    }

    public function messages()
    {
        return [
            'floor_id.*.distinct' => 'Floor can not be duplicated',
        ];
    }
}
