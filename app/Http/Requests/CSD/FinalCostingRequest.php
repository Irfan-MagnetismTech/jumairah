<?php

namespace App\Http\Requests\CSD;

use Illuminate\Foundation\Http\FormRequest;

class FinalCostingRequest extends FormRequest
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
            'project_name'  => 'required',
            'apartment_id'  => 'required',
            'sell_id'       => 'required'
        ];
    }
}
