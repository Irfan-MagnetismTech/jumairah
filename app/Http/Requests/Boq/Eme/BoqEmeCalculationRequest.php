<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;

class BoqEmeCalculationRequest extends FormRequest
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
        $project_id = $this->route('calculation');
        $skip_id = request()->id;
        $budget_head_id = request()->budget_head_id;
        $item_id = request()->item_id;
        return [
            'budget_head_id'            => 'required',
            'item_id'                   => "required|unique:boq_eme_calculations,item_id,project_id,$project_id,budget_head_id,$budget_head_id",
            'boq_eme_rate_id'           => 'required',
            'material_id'               => "required|array",
            'material_id.*'             => "required|distinct|unique:boq_eme_calculations,material_id,$skip_id,id,project_id,$project_id,budget_head_id,$budget_head_id,item_id,$item_id",
            'material_rate'             => 'required',
            // 'labour_rate'               => 'required',
            'quantity'                  => 'required',
            'total_material_amount'     => 'required',
            // 'total_amount'              => 'required'
        ];
    }
}
