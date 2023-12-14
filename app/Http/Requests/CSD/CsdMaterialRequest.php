<?php

namespace App\Http\Requests\CSD;

use Illuminate\Foundation\Http\FormRequest;

class CsdMaterialRequest extends FormRequest
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
        $id = request()->id;
        return [
            'name' => "required|unique:csd_materials,name,$id",
        ];
    }
}
