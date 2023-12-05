<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MouzaRequest extends FormRequest
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
        $thana_id = request()->thana_id;
        return [
            'name' => "required|unique:mouzas,name,$skip_id,id,thana_id,$thana_id",
        ];
    }
}
