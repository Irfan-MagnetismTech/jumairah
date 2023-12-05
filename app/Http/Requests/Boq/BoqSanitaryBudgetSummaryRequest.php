<?php

namespace App\Http\Requests\Boq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BoqSanitaryBudgetSummaryRequest extends FormRequest
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
        if(request()->type == '0'){
                return [
                    'buildup_area'  => 'required',
//                    'rate_per_unit' =>'required',
                    'total_amount'  => 'required',
                    'project_id'    => Rule::unique('sanitary_budget_summaries','project_id')->ignore($this->sanitaryBudgetSummary)->where('project_id', $this->project_id)
                ];
        }else{
            return [
                'buildup_area'  => 'required',
                'rate_per_unit' =>'required',
                'total_amount'  => 'required',
            ];
        }

    }
}
