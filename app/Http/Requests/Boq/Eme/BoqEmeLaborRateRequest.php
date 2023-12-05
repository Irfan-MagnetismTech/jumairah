<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;

class BoqEmeLaborRateRequest extends FormRequest
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
            'parentwork_id'        => 'array|required',
            'parentwork_id.*'      => 'required',
            'work_id'              => 'array|required',
            'work_id.*'            => 'required',
            'work_labor_rate'     => 'array|required',
            'work_labor_rate.*'   => 'required',
            'work_qty'             => 'array|required',
            'work_qty.*'           => 'required',
            'description'          =>'required',
            'basis_of_measurement' =>'required',
            'type'                 =>'required',
            ];
        }else{
            return [
            'second_layer_parent_id'  => 'required',
            'material_id'             => 'array|required',
            'material_id.*'           => 'required',
            'labor_rate'             => 'array|required',
            'labor_rate.*'           => 'required',
            'qty'                     => 'array|required',
            'qty.*'                   => 'required',
            'basis_of_measurement'    => 'required',
            ];
        }

    }
}
