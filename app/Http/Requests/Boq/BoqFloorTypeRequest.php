<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqFloorTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => ['required', 'array', 'distinct'],
            'name.*'             => ['required', 'string', 'max:255'],
            'has_buildup_area'   => ['required', 'array'],
            'has_buildup_area.*' => ['required', 'boolean'],
        ];
    }
}
