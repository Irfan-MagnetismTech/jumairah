<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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

        return [

            'dob' => "required|date|date_format:d-m-Y",
//            'marriage_anniversary' => "date|date_format:d-m-Y|after:dob",
            'father_name' => "required",
            'mother_name' => "required",
            'nationality' => "required",
            'profession' => "required",
            'present_address' => "required",
            'permanent_address' => "required",
            'email' => "required",
            'name' => "required",
            'lead_id' => "required",
            'picture' =>"mimes:jpg,jpeg,png,bmp,tiff",
            'auth_picture' =>"mimes:jpg,jpeg,png,bmp,tiff",
            "nominee_name"=> "required"
//            "nominee_name"=> "required|array",
//            "nominee_name.*" => ['required','string','distinct', new Uppercase()],
        ];
    }


    public function messages()
    {
        return
            [
                'dob.required' => 'Date of Birth is Required.',
                'lead_id.required' => 'Please Entered the Valid Client',
                'dob.date_format' => 'The date of birth does not match the format d-m-Y.',
                'picture.mimes' =>'Please insert only image in Client Picture',
                'auth_picture.mimes' =>'Please insert only image in Authorized Picture',
//                'marriage_anniversary.date_format' => 'Marriage anniversary does not match the format d-m-Y.',
//                'marriage_anniversary.after:dob' => 'Marriage anniversary must be a date after Date of Birth'
//                'nominee_name.*.distinct' => "There is a duplicate Nominee Name. Please Enter Distinct Nominee Name."

            ];
    }
}
