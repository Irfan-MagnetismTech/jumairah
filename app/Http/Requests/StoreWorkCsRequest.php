<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkCsRequest extends FormRequest
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
            'effective_date'          => ['required', 'date', 'date_format:d-m-Y'],
            'expiry_date'             => ['nullable','date', 'date_format:d-m-Y'],
            'remarks'                 => ['present', 'nullable', 'string'],
            'title'                   => ['required', 'string'],
            'cs_type'                 => ['required', 'string'],
            'project_id'              => ['required'],

            'supplier_id'             => ['required', 'array'],
            'supplier_id.*'           => ['required', 'exists:suppliers,id', 'distinct'],
            'checked_supplier'        => ['required', 'array'],
            'address'                 => ['required', 'array'],
            'address.*'               => ['required', 'string'],
            // 'contact'                 => ['required', 'array'],
            // 'contact.*'               => ['required', 'string'],
            'price'                   => ['required', 'array'],
            'price.*'                 => ['required', 'numeric'],
            'work_level'              => ['required', 'array'],
            'work_level.*'            => ['required', 'string'],
            'work_description'        => ['required', 'array'],
            'work_description.*'      => ['required', 'string'],
            'work_quantity'           => ['required', 'array'],
            'work_quantity.*'         => ['required', 'string'],
            'work_unit'               => ['required', 'array'],
            'work_unit.*'             => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'material_id.*.distinct' => 'Materials can not be duplicated',
            'supplier_id.*.distinct' => 'Suppliers can not be duplicated',
        ];
    }
}
