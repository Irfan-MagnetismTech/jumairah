<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;

class BoqCivilCalcRequest extends FormRequest
{
    public function rules()
    {
        return [
            'work_id'                            => ['required', 'integer', 'exists:boq_works,id'],
            'boq_floor_id'                       => ['required', 'string', 'exists:boq_floor_projects,boq_floor_project_id'],
            'group_name'                         => ['sometimes', 'nullable', 'string', 'max:255'],
            'sub_location_name'                  => ['sometimes', 'array'],
            'sub_location_name.*'                => ['sometimes', 'nullable', 'string', 'max:255'],
            'boq_reinforcement_measurement_id'   => ['sometimes', 'nullable', 'array'],
            'boq_reinforcement_measurement_id.*' => ['sometimes', 'nullable', 'integer', 'exists:boq_reinforcement_measurements,id'],
            'no_or_dia'                          => ['required', 'array'],
            'no_or_dia.*'                        => ['required', 'numeric', 'max:100000000'],
            'length'                             => ['present', 'array'],
            'length.*'                           => ['present'],
            'breadth_or_member'                  => ['present', 'array'],
            'breadth_or_member.*'                => ['present'],
            'height_or_bar'                      => ['present', 'array'],
            'height_or_bar.*'                    => ['present'],
        ];
    }
}
