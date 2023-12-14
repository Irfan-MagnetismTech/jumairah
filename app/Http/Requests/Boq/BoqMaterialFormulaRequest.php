<?php

namespace App\Http\Requests\Boq;

use App\Rules\CheckUniqueArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqMaterialFormulaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'work_id'        => ['required','exists:boq_works,id'],
            'nested_material_id'   => ['required', 'array',  new CheckUniqueArray('boq_material_formulas', 'work_id', $this->work_id)],
            'nested_material_id.*'   => ['required', 'numeric', 'distinct' , 'exists:nested_materials,id'],
            'percentage_value'   => ['required', 'array'],
            'percentage_value.*'   => ['required', 'numeric'],
        ];
    }
}
