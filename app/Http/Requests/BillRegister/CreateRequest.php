<?php

namespace App\Http\Requests\BillRegister;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'bill_no.*' => "required|distinct|unique:bill_registers,bill_no",
            
        ];
    }


    public function messages()
    {
        return [
            'bill_no.*.distinct' => 'Bill No can not be duplicated',
            'bill_no.*.unique' => 'Bill No already been Registered',
        ];
    }
}
