<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvanceAdjustmentRequest extends FormRequest
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
            'date'              => "required|date|date_format:d-m-Y",
            'cost_center_id'    => "required",
            'grand_total'      => "required",
            'balance'           => "required",
            'account_id'        =>"required|array",
            'account_id.*'      =>"required",
            'iou_id'            => "required",
            'description'       => "required|array",
            'description.*'     => "required",
            'amount'            => "required|array",
            'amount.*'          => "required",
            'remarks'           => "required|array",
            'remarks.*'         => "required",
        ];
    }


    public function messages()
    {
        return [
            'cost_center_id.required' => 'Please Search Project Name',
            'grand_total.required'   => 'Total is required',
            'balance.required'        => 'Balance is required',
            'account_id.required'     =>'Please Search Account No',
            'account_id.*.required'   =>'Please Search Account No',
            'iou_id.required'         => 'Please Search Iou no',
            'description.*required'   => 'description is required',
            'amount.*required'        =>'Amount is required',
            'remarks.*.required'      =>'Remarks is required',
        ];
    }
}
