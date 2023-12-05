<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalaryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
//        dd(request()->month);
        return [
            'month' => "required|date:salaries,month",
//            'month' => Rule::unique('salaries')
        ];
    }


}
