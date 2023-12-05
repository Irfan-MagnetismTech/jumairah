<?php

namespace App\Http\Requests\Boq;

use App\Rules\CheckUniqueArray;
use Illuminate\Foundation\Http\FormRequest;

class BoqCivilConsumableBudgetRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nested_material_id'   => ['required', 'array',  new CheckUniqueArray('boq_civil_consumable_budgets', 'nested_material_id', $this->nested_material_id)],
            'nested_material_id.*'   => ['required', 'numeric', 'distinct' , 'exists:nested_materials,id'],
            'quantity'   => ['required', 'array'],
            'quantity.*'   => ['required', 'numeric'],
        ];
    }
}
