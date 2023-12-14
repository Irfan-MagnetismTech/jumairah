<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoqCivilMaterialSpecificationRequest extends FormRequest
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
            'item_head' => ['required', 'max:255'],
            'item_name.*' => ['required', 'max:255'],
            'unit_id.*' => ['required', 'exists:units,id'],
            'specification.*' => ['required', 'max:255'],
            'unit_price.*' => ['required'],
            'remarks' => ['nullable', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'item_head.required' => 'Item Head is required',
            'item_head.max' => 'Item Head may not be greater than 255 characters',
            'item_name.*.required' => 'Item Name is required',
            'item_name.*.max' => 'Item Name may not be greater than 255 characters',
            'unit_id.*.required' => 'Unit is required',
            'unit_id.*.exists' => 'Unit is not exists',
            'specification.*.required' => 'Specification is required',
            'specification.*.max' => 'Specification may not be greater than 255 characters',
            'unit_price.*.required' => 'Unit Price is required',
            'remarks.max' => 'Remarks may not be greater than 255 characters',
        ];
    }
}
