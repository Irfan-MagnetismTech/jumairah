<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;

class BoqEmeBudgetRequest extends FormRequest
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
       $project = $this->route('project')->id;
       $skip_id = request()->id;
        return [
            'budget_head_id'    => 'required|array',
            'budget_head_id.*'    => "required|unique:boq_eme_budgets,budget_head_id,$skip_id,id,project_id,$project",
            // 'rate'              => 'required',
            // 'quantity'          => 'required',
            // 'amount'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'budget_head_id.*.unique'        => 'The Budget for :attribute this Project already been taken',
        ];
    }
}
