<?php

namespace App\Http\Requests\Construction;

use App\Construction\MaterialPlan;
use App\Rules\MaterialPlanRule;
use Illuminate\Foundation\Http\FormRequest;

class MaterialPlanDraftRequest extends FormRequest
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
        // $project_id = request()->project_id;
        // $year = $this->formatYear(request()->from_date);
        // $month = $this->formatMonth(request()->to_date);

        // $material_plan = MaterialPlan::where('year', $year)
        //     ->where('month', $month)
        //     ->where('project_id', $project_id)
        //     ->first();

        //     return empty($material_plan);
        return [
            'from_date'     => 'required',
            'to_date'       => 'required',
            'project_id'    => [new MaterialPlanRule($this->project_id, $this->from_date, $this->to_date, $this->id)]
        ];
    }

}
