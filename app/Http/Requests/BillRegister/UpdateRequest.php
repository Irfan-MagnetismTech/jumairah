<?php

namespace App\Http\Requests\BillRegister;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return [
            'bill_no.*' => "required|unique:bill_registers,bill_no,$skip_id",
            
        ];
    }


    public function messages()
    {
        return [
            'bill_no.*.unique' => 'Bill No already been Registered',
        ];
    }
}
