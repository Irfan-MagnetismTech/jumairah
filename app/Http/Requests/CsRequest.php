<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CsRequest extends FormRequest
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
            'reference_no'            => ['required', 'string', 'max:255', Rule::unique('cs')->ignore($this->comparative_statement, 'reference_no')],
            'effective_date'          => ['required', 'date', 'date_format:d-m-Y'],
            'expiry_date'             => ['required', 'date', 'date_format:d-m-Y', 'after:effective_date'],
            'remarks'                 => ['present', 'nullable', 'string'],

            'material_id'             => ['required', 'array'],
            'material_id.*'           => ['required', 'exists:nested_materials,id', 'distinct'],
            'material_name'           => ['required', 'array'],
            'material_name.*'         => ['required', 'string'],

            'supplier_id'             => ['required', 'array'],
            'supplier_id.*'           => ['required', 'exists:suppliers,id', 'distinct'],
            'supplier_name'           => ['required', 'array'],
            'supplier_name.*'         => ['required', 'string'],
            'supplier_remarks'        => ['array'],
            'supplier_remarks.*'      => ['string'],
            'checked_supplier'        => ['required', 'array'],
            'address'                 => ['required', 'array'],
            'address.*'               => ['required', 'string'],
            // 'contact'                 => ['required', 'array'],
            // 'contact.*'               => ['required', 'string'],
            'collection_way'          => ['required', 'array'],
            'collection_way.*'        => ['required', 'string'],
            'grade'                   => ['required', 'array'],
            'grade.*'                 => ['required', 'string'],
            'vat_tax'                 => ['required', 'array'],
            'vat_tax.*'               => ['required', 'string'],
            'tax'                     => ['required', 'array'],
            'tax.*'                   => ['required', 'string'],
            'credit_period'           => ['required', 'array'],
            'credit_period.*'         => ['required', 'string'],
            'material_availability'   => ['required', 'array'],
            'material_availability.*' => ['required', 'string'],
            'delivery_condition'      => ['required', 'array'],
            'delivery_condition.*'    => ['required', 'string'],
            'required_time'           => ['required', 'array'],
            'required_time.*'         => ['required', 'string'],

            'price'                   => ['required', 'array'],
            'price.*'                 => ['required', 'numeric'],
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
