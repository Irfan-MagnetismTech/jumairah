<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesYearlyBudgetRequest extends FormRequest
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
        $project_id = request()->project_id;
        return [
            'year' => "required|unique:sales_yearly_budgets,year,$skip_id,id,project_id,$project_id",
            'project_id' => 'required',
        ];
    }
}
