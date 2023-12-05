<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NestedMaterialRequest extends FormRequest
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
        $parent_id = array_filter(request()->parent_id, 'strlen');
        // $parent_id = request()->parent_id;
        $parent_id = end($parent_id);
        return [
            'name' => "required|unique:nested_materials,name,$skip_id,id,parent_id,$parent_id"
        ];
    }
}
