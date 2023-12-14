<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;

class BoqWorkRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'             => ['required', 'string'],
            'parent_id'        => ['sometimes', 'nullable', 'numeric', 'exists:boq_works,id'],
            //'material_unit'    => ['nullable', 'numeric', 'exists:units,id'],
            //'labour_unit'      => ['nullable', 'numeric', 'exists:units,id'],
            //'material_unit'    => ['nullable', 'numeric', 'exists:units,id'],
            'is_reinforcement' => ['nullable'],
        ];
    }
}
