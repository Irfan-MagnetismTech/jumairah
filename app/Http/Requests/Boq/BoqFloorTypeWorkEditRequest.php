<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqFloorTypeWorkEditRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'boq_floor_type_id'        => ['required','exists:boq_floor_types,id'],
            'boq_work_id' =>  [
                'required',
                Rule::unique('boq_floor_type_boq_work','boq_work_id')
                    ->ignore($this->floor_type_work)
                    ->where('boq_floor_type_id', $this->boq_floor_type_id)
            ]
        ];
    }
}
