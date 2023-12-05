<?php

namespace App\Http\Requests;

use App\SellsClient;
use Illuminate\Foundation\Http\FormRequest;

class SellsRequest extends FormRequest
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
        // dd(request()->installment);
        $id = request()->sell_id;
        $sale = SellsClient::where('sell_id', $id)->whereNotNull('name_transfer_id')->first();
        $total_installment=request()->total_installment;
        return [
            //
            'client_id'=>"required_if:$sale,==,null",
            'booking_money_date' => "required|date|date_format:d-m-Y",
            'downpayment_date' => "required|date|date_format:d-m-Y",
            'sell_date' => "required|date|date_format:d-m-Y",
            'installment'=>'required|in:'.$total_installment,
            "installment_date"=> "required|array",
            'installment_date.*'=>['required','distinct', 'date', 'date_format:d-m-Y'],
            "parking_composite"=> "array",
            "parking_composite.*" => ['string','distinct']
        ];
    }
    public function messages()
    {
        return
            [
                'installment.in' => 'Total installment must be equal to Remain Amount.',
//                'installment_date.*.distinct' => ":attribute There is a duplicate Installment Date. Please Enter Distinct Installment Date.",
                'parking_composite.*.distinct' => "There is a Parking Name. Please Enter Distinct Parking."
        ];
    }

}
