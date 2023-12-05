<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;

class BoqEmeUtilityBillRequest extends FormRequest
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
            'client_id'            => 'required',
            'apartment_id'         => 'required',
            'period'               => 'required'
            ];
    }
}
