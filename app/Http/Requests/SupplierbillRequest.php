<?php

namespace App\Http\Requests;

use App\Rules\IsMprExist;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierbillRequest extends FormRequest
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
            'cost_center_id' => "required",
            'purpose' => "required",
            'date' => "required|date|date_format:d-m-Y",
            'po_no' => "required|array",
            'mpr_no' => "required|array",
            'supplier_id' => "required|array",
            'register_serial_no' => "required",
            'amount' => "required|array"
        ];
    }
}
