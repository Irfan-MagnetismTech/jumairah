<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseorderRequest extends FormRequest
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
            'date'=>"required|date|date_format:d-m-Y",
            'mpr_no'=>"required",
            'cs_id'=>"required",
            'supplier_id'=>"required",
            'final_total'=>"required",
            'source_tax'=>"required",
            'source_vat'=>"required",
            'carrying'=>"required",
            'material_id'=>"required|array",
            'quantity'=>"required|array",
            'unit_price'=>"required|array",
            'total_price'=>"required|array",
            'required_date'=>"required|array",
            'required_date.*'=>['required','date','date_format:d-m-Y'],
        ];
    }
}
