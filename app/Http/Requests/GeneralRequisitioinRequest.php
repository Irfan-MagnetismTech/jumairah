<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GeneralRequisitioinRequest extends FormRequest
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
            'mpr_no'            => ['required', Rule::unique('requisitions', 'mpr_no')->ignore($this->general_requisition)],
            'cost_center_id'    =>"required",
            'applied_date'      =>"required|date|date_format:d-m-Y",
            'material_id'       =>"required|array",
            'quantity'          =>"required|array",
            'approval_layer_id' =>"required"
        ];
    }
}
