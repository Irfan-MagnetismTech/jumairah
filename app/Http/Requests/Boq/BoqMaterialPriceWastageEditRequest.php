<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqMaterialPriceWastageEditRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        return [
//            'price'   => ['required'],
//            'wastage'   => ['sometimes'],
//            'nested_material_id' =>  [
//                'required',
//                Rule::unique('boq_material_price_wastages','nested_material_id')
//                    ->ignore($this->materialPriceWastage)
//                    ->where('nested_material_id', $this->nested_material_id)
//            ]
//        ];
    }
}
