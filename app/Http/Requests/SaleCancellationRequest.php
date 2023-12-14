<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleCancellationRequest extends FormRequest
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
                'sell_id'  => "required|unique:sale_cancellations,sell_id,$skip_id,id",
        ];
    }
}
