<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;

class FloorRequest extends FormRequest
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
            'name'        => ['required', 'string'],
            'parent_id'   => ['sometimes','nullable', 'numeric', 'exists:floors,id'],
            'type_id'   => ['required', 'numeric'],
        ];
    }
}
