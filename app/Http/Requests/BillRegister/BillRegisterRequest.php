<?php

namespace App\Http\Requests\BillRegister;

use Illuminate\Foundation\Http\FormRequest;

class BillRegisterRequest extends FormRequest
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
            'serial_no' => "required|array",
            'serial_no.*' => "required|distinct|unique:bill_registers,serial_no,$skip_id",
            'supplier_id' => "required|array",
            'supplier_id.*' => "required",
            'amount' => "required|array",
            'amount.*' => "required",
            // 'department_id' => "required|array",
            // 'department_id.*' => "required",
            // 'employee_id' => "required|array",
            // 'employee_id.*' => "required",
        ];
    }

    public function messages()
    {
        return [
            'serial_no.*.distinct' => 'Serial No can not be duplicated',
            'serial_no.*.unique' => 'Serial No already been Registered',
            'serial_no.*.required' => 'Serial No is required',
            'supplier_id.*.required' => 'Please Select Supplier',
            'amount.*.required' => 'Amount is required',
            // 'department_id.*.required' => 'Please Select Department',
            // 'employee_id.*.required' => 'Please Select Employee',

        ];
    }
}
