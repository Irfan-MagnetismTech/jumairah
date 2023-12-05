<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqCivilConsumableBudgetEditRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity'        => ['required','numeric'],
            'nested_material_id' =>  [
                'required',
                Rule::unique('boq_civil_consumable_budgets','nested_material_id')
                    ->ignore($this->civilConsumableBudget)
                    ->where('nested_material_id', $this->nested_material_id)
            ]
        ];
    }
}
