<?php

namespace App\Http\Requests\Construction;

use Illuminate\Foundation\Http\FormRequest;

class TentativeBudgetRequest extends FormRequest
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

        $skip_id = request()->id;
        $applied_year = request()->applied_year;
        $cost_center_id = request()->cost_center_id;
        return [
            'applied_year' => 'required',
            'cost_center_id' => 'required',
            'project_name' => 'required',
            'tentative_month' => 'required|array',
            'tentative_month.*' => "required|distinct|unique:tentative_budgets,tentative_month,$skip_id,id,applied_year,$applied_year,cost_center_id,$cost_center_id",
            'material_cost' => 'required|array',
            'material_cost.*' => 'required',
            'labor_cost' => 'required|array',
            'labor_cost.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tentative_month.*.distinct' => 'Month can not be duplicated',
            'tentative_month.*.unique' => 'Budget for a month already been given',
        ];
    }
}
