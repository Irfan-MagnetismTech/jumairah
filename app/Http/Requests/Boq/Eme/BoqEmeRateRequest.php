<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;

class BoqEmeRateRequest extends FormRequest
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
        $type = request()->type;
        if($type){
            return [
            'parentwork_id'        => 'required',
            'work_id'              => 'array|required',
            'work_id.*'            => 'required',
            'labor_unit'           => 'array|required',
            'labor_unit.*'         => 'required',
            'work_labour_rate'     => 'array|required',
            'work_labour_rate.*'   => 'required',
            ];
        }else{
            return [
            'parent_id_second'  => 'required',
            'material_id'       => 'array|required',
            'material_id.*'     => 'required',
            'labour_rate'       => 'array|required',
            'labour_rate.*'     => 'required'
            ];
        }
    }
}
