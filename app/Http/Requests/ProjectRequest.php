<?php

namespace App\Http\Requests;

use App\Rules\Lowercase;
use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
        $share_sum = 0;
        $share_sum= request()->landowner_share+request()->developer_share;
        $sum_of_sellable_area = request()->lO_sellable_area+ request()->developer_sellable_area;
        $type_id = request()->id;

        return [
            'name' => "required|unique:projects,name,$skip_id",
            'shortName' => ['required', new Uppercase(), Rule::unique('projects', 'shortName')->ignore($this->project)],
            'signing_date' => "required|date|date_format:d-m-Y",
            'cda_approval_date' => "required|date|date_format:d-m-Y|after:signing_date",
            'innogration_date' => "nullable|date|date_format:d-m-Y|after:cda_approval_date",
            'handover_date' => "nullable|date|date_format:d-m-Y|after:innogration_date",
            'location' => "required",
            'category' => "required",
            'storied' => "required",
            'res_storied_from' => "required_if:category,==,Residential cum Commercial",
            'res_storied_to' => "required_if:category,==,Residential cum Commercial",
            'com_storied_from' => "required_if:category,==,Residential cum Commercial",
            'com_storied_to' => "required_if:category,==,Residential cum Commercial",
            'landsize' => "required",
            'buildup_area' => "required",
            'sellable_area' => "required",
            'units' => "required",
            'landowner_share' => "required",
            'developer_share' => "required",
            'landowner_unit' => "required",
            'developer_unit' => "required",
            'landowner_parking' => "required",
            'developer_parking' => "required",
            'lO_sellable_area' => "required|lt:sellable_area",
            'developer_sellable_area' => "required|lt:sellable_area",
            "size"=> "required|array",
            "type_name"=> "required|array",
            "type_name.*" => ['required','string','distinct', new Uppercase()],
        ];
    }

    public function messages(){
        return
        [
            'lO_sellable_area.lt:sellable_area'=> "Landowner sellable area must be less than sellable area.",
            'developer_sellable_area.lt:sellable_area'=> "Developer sellable area must be less than sellable area.",
            'type_name.*.distinct' => "There is a duplicate Type Name. Please Enter Distinct Type Name."
        ];

    }
}
