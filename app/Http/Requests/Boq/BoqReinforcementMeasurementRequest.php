<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqReinforcementMeasurementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dia'   => [
                'required', 'numeric',
                Rule::unique('boq_reinforcement_measurements')->ignore($this->reinforcementMeasurement)
            ],
            'weight'   => ['required'],
            'unit_id'   => ['required', 'numeric', 'exists:units,id'],
        ];
    }
}
