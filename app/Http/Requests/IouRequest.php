<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IouRequest extends FormRequest
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
        if (request()->switch == 'employee') {
            return [
                'cost_center_id'        => "required",
                'applied_date'          => "required|date|date_format:d-m-Y",
                'employee_purpose'      => "required|array",
                'employee_purpose.*'    => "required",
                // 'employee_remarks'      => "required|array",
                // 'employee_remarks.*'    => "required",
                'employee_amount'       => "required|array",
                'employee_amount.*'     => "required",
                'employee_total_amount' => "required"
            ];
        } elseif (request()->switch == 'supplier') {
            return [
                'cost_center_id'        => "required",
                'applied_date'          => "required|date|date_format:d-m-Y",
                'remarks'               => "required",
                'supplier_id'           => "required",
                'po_no'                 => "required",
                'purpose'      => "required|array",
                'purpose.*'    => "required",
                'amount'       => "required|array",
                'amount.*'     => "required",
                'total_amount' => "required"
            ];
        } else {
            return [
                'cost_center_id'            => "required",
                'applied_date'              => "required|date|date_format:d-m-Y",
                'remarks'                   => "required",
                'supplier_id'               => "required",
                'work_order_no'             => "required",
                'workorder_id'              => "required",
                'purpose'      => "required|array",
                'purpose.*'    => "required",
                'amount'       => "required|array",
                'amount.*'     => "required",
                'total_amount' => "required"
            ];
        }
    }

    public function messages()
    {
        return [
            'cost_center_id.required'               => 'Project Name is Required',
            'supplier_id.required'                  => 'Supplier Name is Required',
            'employee_purpose.required'             => 'Purpose is Required',
            'employee_purpose.*.required'           => 'Purpose is Required',
            // 'employee_remarks.required'             => 'Employee Purpose is Required',
            // 'employee_remarks.*.required'           => 'Employee Purpose is Required',
            'employee_amount.required'              => 'Amount is Required',
            'employee_amount.*.required'            => 'Amount is Required',
            'supplier_purpose.required'             => 'Purpose is Required',
            'supplier_purpose.*.required'           => 'Purpose is Required',
            'po_no.required'                        => 'PO No is Required',
            'po_no.*.required'                      => 'PO No is Required',
            'supplier_amount.required'              => 'Amount is Required',
            'supplier_amount.*.required'            => 'Amount is Required',
            'employee_total_amount.required'        => 'Total Amount is Required',
            'supplier_total_amount.required'        => 'Total Amount is Required',
            'workorder_id.required'                 => 'Please search Work Order No',
            'workorder_id.*.required'               => 'Please search Work Order No',
            'work_order_no.required'                => 'Work Order No is Required',
            'work_order_no.*.required'              => 'Work Order is Required',
            'construction_purpose.required'         => 'Purpose is Required',
            'construction_purpose.*.required'       => 'Purpose is Required',
            'construction_amount.required'          => 'Amount is Required',
            'construction_amount.*.required'        => 'Amount is Required',
            'construction_total_amount.required'    => 'Total Amount is Required',
        ];
    }
}
