<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class orgSlotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'max:20',
            'slot_type' => 'required',
            'total_slot' => 'required',
            'per_hr_amt' => 'required',
        ];
    }
}
