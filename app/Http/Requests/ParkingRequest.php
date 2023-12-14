<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;

class ParkingRequest extends FormRequest
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

            'project_id' => "required",
            'location' => "required",
            'total_parking' => "required",
            'level' => 'required_if:location,==,Basement',
            "parking_name"=> "required|array",
            "parking_name.*" => ['required','string','distinct', new Uppercase()],
        ];
    }
    public function messages()
    {
        return [
            'project_id.required' => "The Project Name is required",
            'level.required_if' => "Please add level",
            'parking_name.*.distinct' => "There is a duplicate Parking Name. Please Enter Distinct Parking Name."


        ];
    }
}
