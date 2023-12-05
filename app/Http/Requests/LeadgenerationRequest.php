<?php

namespace App\Http\Requests;

use App\Sells\Leadgeneration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadgenerationRequest extends FormRequest
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
        $id = request()->id;
        $code = request()->country_code;
        $number = request()->contact;
        return [
            // 'contact' => "required|unique:leadgenerations,contact,$id,id,country_code,$code",
            // 'contact' => [
            //     'required', Rule::unique('leadgenerations')
            //         ->where(function ($query) use ($code, $number) {
            //             return $query->orWhere('contact_alternate',$number)
            //             ->orWhere('contact_alternate_three',$number)
            //             ->orWhere('contact',$number);
            //         })
            //         ->where('country_code', $code)
            //         // ->ignore($this->id)
            // ],
            'contact' => 'required|unique:leadgenerations,contact,' . $this->id . ',id,contact_alternate,' . $number,
            // 'contact_alternate' => 'different:contact,contact_alternate_three,spouse_contact',
            // 'contact_alternate_three' => 'different:contact,contact_alternate,spouse_contact',
            // 'spouse_contact' => 'different:contact,contact_alternate,contact_alternate_three'
        ];
    }
    public function messages()
    {
        $id = request()->id;
        $contact = request()->contact;
        // dd($contact);
    //    $duplicatsInfo = Leadgeneration::where('contact',$contact)->first();
        return [
        //    'contact' => "$duplicatsInfo->name ?? '' - $duplicatsInfo->profession ?? '' - is Already Exists for $duplicatsInfo->country_code-$duplicatsInfo->contact ",
            'contact.unique' => 'The contact is Already Exists.',
            'contact_alternate.different' => 'The contact optional and Contact must be different.'
        ];
    }
}
