<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqMaterialFormulaEditRequest extends FormRequest
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
            'percentage_value'   => ['required', 'numeric'],
            'nested_material_id' =>  [
                'required',
                Rule::unique('boq_material_formulas','nested_material_id')
                    ->ignore($this->materialFormula)
                    ->where('work_id', $this->work_id)
            ]
        ];
    }
}
