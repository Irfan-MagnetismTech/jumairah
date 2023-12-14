<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleCancellationApprovalRequest extends FormRequest
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
//            'transactionable_id.transactions'  => "unique:transactions,transactionable_id,transactionable_type,$skip_id,id",
        ];
    }
}
