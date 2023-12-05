<?php

namespace App\Http\Requests\Boq;

use App\Rules\CheckUniqueArray;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BoqMaterialPriceWastageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project_id = request()->project_id;
        $skip_id = request()->id;
        $other_material_head = isset(request()->other_material_head) ? request()->other_material_head : '---';

        return [
            // 'nested_material_id'   => ['required', 'array',  new CheckUniqueArray('boq_material_price_wastages', 'nested_material_id', $this->nested_material_id, 'This material already exists.')],
            'nested_material_id'    => 'required|array',
            'nested_material_id.*'  => "required|distinct|unique:boq_material_price_wastages,nested_material_id,$skip_id,id,project_id,$project_id,other_material_head,$other_material_head",
            'price'                 => 'required|array',
            'price.*'               => 'required|numeric',
            'wastage'               => 'sometimes|array',
            'wastage.*'             => 'sometimes',
        ];
    }
}
