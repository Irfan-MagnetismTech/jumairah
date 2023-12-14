<?php

namespace App\Http\Requests\CSD;

use Illuminate\Foundation\Http\FormRequest;

class CsdMaterialRateRequest extends FormRequest
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
        $id = request()->id;
        return [
            'material_id' => "required|unique:csd_material_rates,material_id,$id",
            'actual_rate' => 'required',
            'demand_rate' => 'required',
            'refund_rate' => 'required'
        ];
    }
}
