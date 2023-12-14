<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;

class BdInventoryRequest extends FormRequest
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
        // $id = request()->id;
        return [
            // 'year'              => "required|unique:bd_inventories,name,$id",
            'applied_date'      => 'required|date|date_format:Y-m-d',
            'signing_money'     => 'required',
            'inventory_value'   => 'required'
        ];
    }
}
