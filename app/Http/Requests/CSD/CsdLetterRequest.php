<?php

namespace App\Http\Requests\CSD;

use Illuminate\Foundation\Http\FormRequest;

class CsdLetterRequest extends FormRequest
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
            'letter_title'      => 'required',
            'letter_date'       => 'required',
            'project_id'        => 'required',
            'address_word_one'  => 'required',
            'sell_id'           => 'required',
            'letter_subject'    => 'required',
            'address_word_two'  => 'required',
            'letter_body'       => 'required'
        ];
    }
}
