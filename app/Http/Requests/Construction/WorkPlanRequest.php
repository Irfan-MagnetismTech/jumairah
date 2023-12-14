<?php

namespace App\Http\Requests\Construction;

use App\Http\Requests\Boq\Request;
use Illuminate\Foundation\Http\FormRequest;

class WorkPlanRequest extends FormRequest
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
        $workPlan_id = request()->workPlan_id;
        $id = request()->id;
        return [
            'project_id'    => 'required',
            'work_id'       => 'required',
            'target'        => 'required',
            'description'   => 'required',
            'start_date'    => 'required',
            'finish_date'   => 'required'
        ];
    }

}
