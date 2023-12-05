<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionYearlyBudgetRequest extends FormRequest
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
            'year' => "required|unique:collection_yearly_budgets,year,$skip_id,id,project_id,$project_id",
//            'project_id' => "required|unique:collection_yearly_budget_details,project_id,$skip_id,yearly_budget_id,",
        ];
    }
}
