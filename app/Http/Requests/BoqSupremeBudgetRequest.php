<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoqSupremeBudgetRequest extends FormRequest
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
            'budget_for'    => Rule::requiredIf( function (){
                return request()->path() == 'boqSupremeBudgets';
            }),
            'project_id'    =>     "required",
            'material_id'   =>     "required|array",
            'material_id.*' =>     "required",
            'quantity'      =>     "required|array",
            'quantity.*'    =>     "required"
        ];
    }
}
