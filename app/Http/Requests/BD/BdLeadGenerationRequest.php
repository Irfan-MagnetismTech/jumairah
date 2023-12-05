<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;

class BdLeadGenerationRequest extends FormRequest
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
        return [
            'land_under'        => 'required',
            'lead_stage'        => 'required',
            'category'          => 'required',
            'project_category'  => 'required',
            'source_id'         => 'required',
            'division_id'       => 'required',
            'district_id'       => 'required',
            'thana_id'          => 'required',
            'land_size'         => 'required',
            'land_status'       => 'required',
            'front_road_size'   => 'required',
            'land_location'     => 'required',
            'storey'            => 'required',
            'basement'          => 'required',
            'land_location'     => 'required',
            'name'              => 'required',
            'name.*'            => 'required',
            'mobile'            => 'required',
            'mobile.*'          => 'required',
            'present_address'   => 'required',
            'present_address.*' => 'required',
            'survey_report'     => 'mimes:jpeg,png,pdf,jpg',
            'picture'           => 'array',
            'picture.*'         => 'mimes:jpeg,png,pdf,jpg'
        ];
    }
}
