<?php

namespace App\Http\Requests\Construction;

use App\Construction\MaterialPlan;
use App\Rules\MaterialPlanRule;
use Illuminate\Foundation\Http\FormRequest;

class MaterialPlanRequest extends FormRequest
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
            'from_date'     => 'required',
            'to_date'       => 'required',
            'project_id'    => [new MaterialPlanRule($this->project_id, $this->from_date, $this->to_date, $this->id)],
            'material_id'   => 'required|array',
            'material_id.*' => 'required',
        ];
    }

    public function messages(){
        return [
            'material_id.required'      => 'Material name is required',
            'material_id.*.required'    => 'Material name is required',
        ];
    }

}
