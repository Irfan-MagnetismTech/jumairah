<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
//        dd(request()->all());
        $skip_id = request()->id;
        $project_id = request()->project_id;
        return [
            'name' => "required|unique:apartments,name,$skip_id,id,project_id,$project_id",
            'project_id' => "required",
            'floor' => "required",
            'face' => "required",
            'owner' => "required",
        ];
    }

    public function messages()
    {
        return
        [
            'name.required' => 'Apartment ID is Required.',
            'name.unique' => 'Apartment ID has been taken already.'
        ];
    }
}
