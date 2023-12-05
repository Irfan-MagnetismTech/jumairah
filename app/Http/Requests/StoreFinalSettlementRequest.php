<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinalSettlementRequest extends FormRequest
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
        $project_id = request()->project_id;
//        dd(request()->sale_id);
        return [
            'sale_id' => "required|unique:final_settlements,sale_id,$skip_id,id,project_id,$project_id"
        ];
    }

    public function messages()
    {
        return
            [
                'sale_id.required' => 'Client is Required.',
                'sale_id.unique' => 'The Client has been already taken for this Project',
            ];
    }
}
