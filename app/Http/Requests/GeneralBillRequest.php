<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralBillRequest extends FormRequest
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
            'project_id'        => "required",
            'total_amount'      => "required",
            'account_id'        => "required|array",
            'account_id.*'      => "required",
            'amount'            => "required|array",
            'amount.*'          => "required",
            'attachment'        => "array",
            'attachment.*'      => "mimetypes:png, jpg, jpeg, pdf",
        ];
    }
}
