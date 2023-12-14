<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'loan_type' => "required",
            'loanable_id' => "required",
            'loan_number' => "required|unique:loans,loan_number,$skip_id",
        ];
    }
}
