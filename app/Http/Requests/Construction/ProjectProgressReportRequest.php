<?php

namespace App\Http\Requests\construction;

use Illuminate\Foundation\Http\FormRequest;

class ProjectProgressReportRequest extends FormRequest
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
        return [
            'cost_center_id'        => "required|unique:project_progress_report_details,cost_center_id,$skip_id,id",
            'date_of_inception'     => 'required|array',
            'date_of_inception.*'   => 'required|date|date_format:d-m-Y',
            'date_of_completion'    => 'required|array',
            'date_of_completion.*'  => 'required|date|date_format:d-m-Y'
        ];
    }
}
