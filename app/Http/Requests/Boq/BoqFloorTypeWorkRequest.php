<?php

namespace App\Http\Requests\Boq;

use App\Rules\CheckUniqueArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqFloorTypeWorkRequest extends FormRequest
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
            'boq_work_id'   => ['required', 'array',  new CheckUniqueArray('boq_floor_type_boq_work', 'boq_floor_type_id', $this->boq_floor_type_id)],
            'boq_work_id.*'   => ['required', 'numeric', 'distinct' , 'exists:boq_works,id'],
        ];
    }
}
