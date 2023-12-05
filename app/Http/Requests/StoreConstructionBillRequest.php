<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstructionBillRequest extends FormRequest
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
        if(request()->type == 0){
            return [
                'work_order_no'     => 'required',
                'workorder_id'      => 'required',
                'project_name'      => 'required',
                'cost_center_id'    => 'required',
                'supplier_name'     => 'required',
                'supplier_id'       => 'required',
                'bill_amount'       => 'required',
                'percentage'        => 'required',
                'year'              => 'required',
                'month'             => 'required',
                'week'              => 'required',
            ];
        }else{
            return [
                'work_order_no'     => 'required',
                'workorder_id'      => 'required',
                'project_name'      => 'required',
                'cost_center_id'    => 'required',
                'supplier_name'     => 'required',
                'supplier_id'       => 'required',
                'bill_amount'       => 'required',
                'percentage'        => 'required',
                'year'              => 'required',
                'month'             => 'required',
                'week'              => 'required',
            ];
        }
    }


    public function messages()
    {
        
        return [
            'work_order_no.required'        => 'Work Order is Required',
            'workorder_id.required'         => 'Work Order is Required',
            'workorder_rate_id.required'    => 'Work Order Rate is required',
            'project_name.required'         => 'Project is Required',
            'cost_center_id.required'       => 'Project is Required',
            'supplier_name.required'        =>'Suppliers is required',
            'supplier_id.required'          => 'Suppliers is required',
            'bill_amount.required'          => 'Bill Amount is Required',
            'percentage.required'           => 'Percentage is required',
            'year.required'                 => 'Year is required',
            'month.required'                => 'Month is required',
            'week.required'                 => 'Week is Required',
        ];
    }
}
