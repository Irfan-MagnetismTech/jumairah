<?php

namespace App\Http\Requests\BD;

use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
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
            'letter_date'       => 'required',
            'cost_center_id'    => 'required',
            'address_word_one'  => 'required',
            'letter_subject'    => 'required',
            'address_word_two'  => 'required',
            'letter_body'       => 'required'
        ];
    }
}
