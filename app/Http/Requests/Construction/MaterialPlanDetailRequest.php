<?php

namespace App\Http\Requests\Construction;

use Illuminate\Foundation\Http\FormRequest;

class MaterialPlanDetailRequest extends FormRequest
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
            'material_id'       => 'required',
            'unit_id'           => 'required',
            'total_quantity'    => 'required'
        ];
    }
}
