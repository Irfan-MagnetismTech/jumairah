<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCollectionApprovalRequest extends FormRequest
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
            'approval_status'               => "required",
            'approval_date'                 => "required",
            'bank_account_id'               => 'required_without:sundry_creditor_account_id',
            'sundry_creditor_account_id'    => 'required_without:bank_account_id',
            'bank_account_name'             => "required_without:sundry_creditor_account_id",
            'salecollection_id'             => "required|unique:sales_collection_approvals,salecollection_id,$skip_id,id",
            'bill_no.*'                     => ['required_without:bank_account_id','distinct'],
            'reason' => "required_if:approval_status,==,Dishonored|required_if:approval_status,==,Canceled|required_if:approval_status,==,Hold"
        ];
    }

    public function messages()
    {
        return
            [
                'bill_no.*' => 'The Bill No is Duplicate',
            ];
    }
}
