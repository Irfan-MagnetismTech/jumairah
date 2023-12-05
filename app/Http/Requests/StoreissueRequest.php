<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreissueRequest extends FormRequest
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
            'cost_center_id'=>"required",
            'sin_no'=>"required",
            'srf_no'=>"required",
            'date'=>"required|date|date_format:d-m-Y",
            'material_id'=>"required|array",
            'ledger_folio_no'=>"required|array",
            'purpose'=>"required|array",
            'issued_quantity'=>"required|array",
        ];
    }
}
